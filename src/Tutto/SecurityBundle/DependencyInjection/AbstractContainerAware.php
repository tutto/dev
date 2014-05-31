<?php

namespace Tutto\SecurityBundle\DependencyInjection;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use \LogicException;
use Tutto\SecurityBundle\Entity\Account;

/**
 * Class AbstractContainerAware
 * @package Tutto\SecurityBundle\DependencyInjection
 */
abstract class AbstractContainerAware extends ContainerAware {
    /**
     * @return null|Account
     */
    public function getAccount() {
        if($this->container->has('security.context')) {
            return $this->container->get('security.context')->getToken()->getUser();
        }
    }

    /**
     * @param $class
     * @return EntityRepository
     */
    public function getRepository($class) {
        if($this->container->has('doctrine')) {
            return $this->container->get('doctrine')->getRepository($class);
        }

        throw new LogicException('The DoctrineBundle is not registered in your application.');
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->container->get('request');
    }
} 