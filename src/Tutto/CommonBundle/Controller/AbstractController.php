<?php

namespace Tutto\CommonBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;

use LogicException;
use Swift_Message;
use Tutto\SecurityBundle\Entity\Account;

/**
 * Class AbstractController
 * @package Tutto\CommonBundle\Controller
 */
class AbstractController extends Controller implements ContainerAwareInterface {
    const FLASH_BAG_SUCCESS = 'success';
    const FLASH_BAG_ALERT   = 'alert';
    const FLASH_BAG_ERROR   = 'error';
    const MESSAGE_SUCCESS   = 'flash_bag.message.success';
    const MESSAGE_ALERT     = 'flash_bag.message.alert';
    const MESSAGE_ERROR     = 'flash_bag.message.error';

    /**
     * @param string|null $message
     * @return AbstractController
     */
    protected function addFlashSuccess($message = self::MESSAGE_SUCCESS) {
        $this->addFlashMessage(self::FLASH_BAG_SUCCESS, $message);
        return $this;
    }

    /**
     * @param string|null $message
     * @return $this
     */
    protected function addFlashError($message = self::MESSAGE_ERROR) {
        $this->addFlashMessage(self::FLASH_BAG_ERROR, $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    protected function addFlashAlert($message = self::MESSAGE_ALERT) {
        $this->addFlashMessage(self::FLASH_BAG_ALERT, $message);
        return $this;
    }

    /**
     * @param $type
     * @param $message
     * @return AbstractController
     */
    protected function addFlashMessage($type, $message) {
        $this->get('session')->getFlashBag()->add($type, $message);
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->get('request');
    }

    /**
     * @return null|SessionInterface
     */
    public function getSession() {
        return $this->getRequest()->getSession();
    }

    /**
     * @param $class
     * @return EntityRepository
     */
    public function getRepository($class) {
        return $this->getDoctrine()->getRepository($class);
    }

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEm($name = null) {
        return $this->getDoctrine()->getManager($name);
    }

    /**
     * @param $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null) {
        return $this->get('translator')->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @return bool
     */
    public function isPost() {
        return $this->getRequest()->isMethod('POST');
    }

    /**
     * @return bool
     */
    public function isGet() {
        return $this->getRequest()->isMethod('GET');
    }

    /**
     * @param $email
     * @param $subject
     * @param $template
     * @param array $vars
     * @return int
     */
    protected function sendEmail($email, $subject, $template, array $vars = array()) {
        $message = Swift_Message::newInstance()
            ->setSubject($this->trans($subject))
            ->setCharset('utf8')
            ->setTo($email)
            ->setContentType('text/html')
            ->setBody(
                $this->renderView(
                    $template,
                    $vars
                )
            );

        return $this->get('mailer')->send($message);
    }

    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $type
     * @param null $data
     * @param array $options
     * @return Form
     */
    public function createForm($type, $data = null, array $options = array()) {
        if($type instanceof ContainerAwareInterface) {
            $type->setContainer($this->getContainer());
        }

        return parent::createForm($type, $data, $options);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer() {
        if($this->container === null) {
            throw new LogicException("ContainerInterface was never deployed");
        }

        return $this->container;
    }

    /**
     * @return Account|null
     */
    public function getAccount() {
        return $this->get('security.context')->getToken();
    }
}