<?php

namespace Tutto\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\User;

use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Entity\Account;
use Tutto\SecurityBundle\Form\Type\RegistrationType;
use Tutto\SecurityBundle\Repository\AccountRepository;

use DateTime;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Tutto\SecurityBundle\Repository\RoleRepository;

/**
 * Class RegistrationController
 * @package Tutto\SecurityBundle\Controller
 *
 * @Route("/account")
 * @PrivilegeCheck(omit=true)
 */
class RegistrationController extends AbstractController {
    /**
     * @Route("/registration", name="_registration")
     * @Template()
     */
    public function registerAction(Request $request) {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager    = $this->container->get('fos_user.user_manager');
        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);

        $user = $userManager->createUser();
        $form = $this->createForm(new RegistrationType(), $user);

        if($request->isMethod('post')) {
            if($form->submit($request)->isValid()) {
                if($userManager->findUserByEmail($user->getEmail())) {
                    $this->addFlashError('security.account.emailExists');
                } else {
                    $this->getEm()->beginTransaction();
                    try {
                        $user->setEnabled(false);
                        $user->setRoles([$roleRepository->getByName(Role::MEMBER)]);

                        if ($user instanceof User) {
                            $expiresAt = new DateTime();
                            $expiresAt->add(new \DateInterval('P7D'));
                            $user->setExpiresAt($expiresAt);
                        }

                        $user->setConfirmationToken($this->generateToken());
                        $userManager->updateUser($user);

                        $this->getEm()->commit();
                        return $this->redirect(
                            $this->generateUrl(
                                '_confirmRegistration',
                                array(
                                    'id'    => $user->getId(),
                                    'email' => $user->getEmail()
                                )
                            )
                        );
                    } catch(Exception $ex) {
                        $this->addFlashError($ex->getMessage());
                        $this->getEm()->rollback();
                    }
                }
            } else {
                $this->addFlashError('flash_bag.forms.formNotValid');
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/confirm/{id}-{email}",
     *      name="_confirmRegistration",
     *      requirements={
     *          "id"="\d+",
     *          "email"="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"
     *      }
     * )
     * @Template()
     * @Method({"GET"})
     */
    public function confirmAction($id, $email) {
        /** @var AccountRepository $accountRepository */
        $accountRepository = $this->getRepository(Account::class);
        $account = $accountRepository->get($id, $email);

        if($account instanceof Account) {
            $this->addFlashSuccess('security.account.accountCreated');
            $this->sendEmail(
                $account->getEmail(),
                'security.email.account_created',
                'TuttoSecurityBundle:emails:account-created.html.twig',
                array(
                    'account' => $account
                )
            );
        } else {
            $this->addFlashError('security.account.accountNotCreated');
        }

        return array('account' => $account);
    }

    /**
     * @Route("/activate/{id}-{email}/{token}",
     *      name="_account_activate",
     *      requirements={
                "id"="\d+",
     *          "email"="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"
     *      }
     * )
     * @Template()
     * @Method({"GET"})
     */
    public function activateAction($id, $email, $token) {
        /** @var AccountRepository $repository */
        $repository = $this->getRepository(Account::class);

        $account    = $repository->getBy(array(
            'id'    => (int) $id,
            'email' => addslashes($email),
            'confirmationToken' => addslashes($token)
        ));

        if($account instanceof Account) {
            if($account->isEnabled()) {
                $this->addFlashAlert('security.account.enabledAlready');
            } else {
                $account->setEnabled(true);
                $account->setConfirmationToken(null);
                $this->getEm()->persist($account);
                $this->getEm()->flush();

                $this->addFlashSuccess('security.account.enabled');
                $this->sendEmail(
                    $account->getEmail(),
                    'security.email.account_enabled',
                    'TuttoSecurityBundle::/emails/account-enabled.html.twig',
                    array(
                        'account' => $account
                    )
                );
            }
        } else {
            $this->addFlashError('security.account.notFound');
            return $this->redirect($this->generateUrl('_registration'));
        }

        return array('account' => $account);
    }

    /**
     * @return string
     */
    protected function generateToken() {
        return md5(time());
    }
} 