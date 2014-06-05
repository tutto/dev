<?php

namespace Tutto\CommonBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;

use LogicException;
use Tutto\SecurityBundle\Entity\Account;

/**
 * Class AbstractFormType
 * @package Tutto\CommonBundle\Form
 */
abstract class AbstractFormType extends AbstractType implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
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
     * @return Request
     */
    public function getRequest() {
        return $this->getContainer()->get('request');
    }

    /**
     * @return Account|null
     */
    public function getAccount() {
        return $this->getContainer()->get('security.context')->getToken();
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
        return $this->getContainer()->get('doctrine')->getRepository($class);
    }

    /**
     * @param null $name
     * @return EntityManager|object
     */
    public function getEm($name = null) {
        return $this->getContainer()->get('doctrine')->getManager($name);
    }
}