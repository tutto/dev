<?php

namespace Tutto\CommonBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;

use LogicException;
use Tutto\SecurityBundle\Entity\Account;

/**
 * Class AbstractContainerAware
 * @package Tutto\CommonBundle\DependencyInjection
 */
class AbstractContainerAware implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->get('request');
    }

    /**
     * @return Account|null
     */
    public function getAccount() {
        return $this->get('security.context')->getToken();
    }

    /**
     * @return Session
     */
    public function getSession() {
        return $this->getRequest()->getSession();
    }

    /**
     * @param string $class
     * @return EntityRepository
     */
    public function getRepository($class) {
        return $this->get('doctrine')->getRepository($class);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer() {
        if($this->container === null) {
            throw new LogicException("ContainerInterface was never deployed.");
        }

        return $this->container;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param $key
     * @return object The service
     */
    public function get($key) {
        return $this->getContainer()->get($key);
    }

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEm($name = null) {
        return $this->get('doctrine')->getManager($name);
    }
}