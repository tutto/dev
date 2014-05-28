<?php

namespace Tutto\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\User;

use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Entity\Account;
use Tutto\SecurityBundle\Form\Type\RegistrationType;
use Tutto\SecurityBundle\Repository\AccountRepository;

use DateTime;
use Exception;
use Swift_Message;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tutto\SecurityBundle\Configuration\Privilege;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class RegistrationController
 * @package Tutto\SecurityBundle\Controller
 *
 * @Route(
 *      "/account"
 * )
 * @Privilege(omit=true)
 */
class RegistrationController extends AbstractSecurityController {
    /**
     * @Route("/registration", name="_registration")
     *
     * @Template()
     */
    public function registerAction(Request $request) {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(false);
        $user->addRole(Role::ROLE_MEMBER);

        $form = $this->createForm(new RegistrationType(), $user);

        if($request->isMethod('post')) {
            if($form->submit($request)->isValid()) {
                if($userManager->findUserByEmail($user->getEmail())) {
                    $this->addFlashError('security.account.emailExists');
                } else {
                    $this->getEm()->beginTransaction();
                    try {
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
                                '_confirm',
                                array(
                                    'id'    => $user->getId(),
                                    'email' => $user->getEmail()
                                )
                            )
                        );
                    } catch(Exception $ex) {
                        $this->addFlashError();
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
     *      name="_confirm",
     *      requirements={
     *          "id"="\d+",
     *          "email"="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"
     *      }
     * )
     * @Template()
     * @Method({"GET"})
     */
    public function confirmAction($id, $email) {
        /** @var Account $account */
        $account = $this->getRepository(Account::class)->get($id, $email);

        if($account instanceof Account) {
            $this->addFlashSuccess('security.account.accountCreated');
            $this->sendEmail(
                $account,
                'security.email.account_created',
                'TuttoSecurityBundle:emails:account-created.html.twig'
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
                $this->getEm()->persist($account);
                $this->getEm()->flush();

                $this->addFlashSuccess('security.account.enabled');
                $this->sendEmail(
                    $account,
                    'security.email.account_enabled',
                    'TuttoSecurityBundle::/emails/account-enabled.html.twig'
                );
            }
        } else {
            $this->addFlashError('security.account.notFound');
            return $this->redirect($this->generateUrl('_registration'));
        }

        return array('account' => $account);
    }

    /**
     * @param Account $account
     * @param $subject
     * @param $template
     * @param array $vars
     * @return int
     */
    protected function sendEmail(Account $account, $subject, $template, array $vars = array()) {
        $message = Swift_Message::newInstance()
            ->setSubject($this->trans($subject))
            ->setTo($account->getEmail())
            ->setCharset('utf8')
            ->setContentType('text/html')
            ->setBody(
                $this->renderView(
                    $template,
                    array_merge(
                        array(
                            'account' => $account,
                            'subject' => $subject
                        ),
                        $vars
                    )
                )
            );

        return $this->get('mailer')->send($message);
    }

    /**
     * @return string
     */
    protected function generateToken() {
        return md5(time());
    }
} 