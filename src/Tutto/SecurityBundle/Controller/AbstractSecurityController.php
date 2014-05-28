<?php

namespace Tutto\SecurityBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractSecurityController
 * @package Tutto\SecurityBundle\Controller
 */
abstract class AbstractSecurityController extends Controller {
    const FLASH_BAG_SUCCESS = 'success';
    const FLASH_BAG_ALERT   = 'alert';
    const FLASH_BAG_ERROR   = 'error';

    /**
     * @param string|null $message
     * @return AbstractSecurityController
     */
    protected function addFlashSuccess($message = null) {
        $this->get('form.factory');
        if($message === null) {
            $message = 'flash_bag.message.success';
        }

        $this->addFlashMessage(self::FLASH_BAG_SUCCESS, $message);

        return $this;
    }

    /**
     * @param string|null $message
     * @return $this
     */
    protected function addFlashError($message = null) {
        if($message === null) {
            $message = 'flash_bag.message.error';
        }

        $this->addFlashMessage(self::FLASH_BAG_ERROR, $message);

        return $this;
    }

    /**
     * @param null $message
     * @return $this
     */
    protected function addFlashAlert($message = null) {
        if($message === null) {
            $message = 'flash_bag.message.alert';
        }

        $this->addFlashMessage(self::FLASH_BAG_ALERT, $message);

        return $this;
    }

    /**
     * @param $type
     * @param $message
     * @return AbstractSecurityController
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
     * @return EntityManager
     */
    public function getEm() {
        return $this->getDoctrine()->getManager();
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
} 