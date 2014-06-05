<?php

namespace Tutto\SecurityBundle\Controller;

use Symfony\Component\Form\AbstractType;
use Tutto\SecurityBundle\Entity\Account;
use \Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\SecurityController;
use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;
use \Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Swift_Message;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Form\Type\LoginType;
use Tutto\SecurityBundle\Form\Type\ResetPasswordType;
use Tutto\SecurityBundle\Repository\AccountRepository;

/**
 * Class AuthController
 * @package Tutto\SecurityBundle\Controller
 *
 * @PrivilegeCheck(omit=true)
 */
class AuthController extends SecurityController {
    /**
     * @Route("/login", name="_login")
     * @Template()
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request) {
        $this->generateNewPassword();
        $form    = $this->createForm(new LoginType($this->container));
        $session = $this->getSession();

        if($session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $session->getFlashBag()->add(
                AbstractController::FLASH_BAG_ERROR,
                $session->get(SecurityContextInterface::AUTHENTICATION_ERROR)->getMessage()
            );
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/login_check", name="_login_check")
     * @Template()
     */
    public function checkAction() {
        parent::checkAction();
    }

    /**
     * @Route("/logout", name="_logout")
     * @Template()
     */
    public function logoutAction() {}

    /**
     * @Route("/password/reset", name="_reset_password")
     * @Template()
     */
    public function resetPasswordAction(Request $request) {
        $form = $this->createForm(new ResetPasswordType());

        if($request->isMethod('POST')) {
            if($form->submit($request)->isValid()) {
                $data = $form->getData();
                /** @var AccountRepository $accountRepository */
                $accountRepository = $this->getRepository(Account::class);
                $account = $accountRepository->getBy(array('email' => $data['email']));

                if($account instanceof Account) {
                    $userManager = $this->container->get('fos_user.user_manager');
                    $newPassword = $this->generateNewPassword();
                    $account->setPlainPassword($newPassword);

                    $userManager->updateUser($account);

                    $this->sendEmail(
                        $account,
                        'security:resetPassword',
                        'TuttoSecurityBundle::/emails/account-reset-password.html.twig',
                        array(
                            'new_password' => $newPassword
                        )
                    );
                } else {
                    $this->getSession()->getFlashBag()->add(
                        AbstractController::FLASH_BAG_ERROR,
                        'accountNotFound'
                    );
                }
            } else {
                $this->getSession()->getFlashBag()->add(AbstractController::FLASH_BAG_ERROR, 'form.formNotValid');
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @param AbstractType $type
     * @return FormInterface
     */
    protected function createForm(AbstractType $type) {
        return $this->container->get('form.factory')->create($type);
    }

    /**
     * @return Session
     */
    protected function getSession() {
        return $this->container->get('session');
    }

    /**
     * @param $class
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository($class) {
        return $this->container->get('doctrine')->getRepository($class);
    }

    /**
     * @return string
     */
    protected function generateNewPassword() {
        return substr(
            $this->container->get('fos_user.util.token_generator')->generateToken(),
            0,
            8
        );
    }

    /**
     * @param $message
     * @return string
     */
    protected function trans($message) {
        return $this->container->get('translator')->trans($message);
    }

    /**
     * @param $template
     * @param array $vars
     * @return Response
     */
    protected function renderView($template, array $vars = array()) {
        return $this->container->get('templating')->renderResponse($template, $vars);
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

        var_dump($message->getBody());

//        return $this->container->get('mailer')->send();
    }
}