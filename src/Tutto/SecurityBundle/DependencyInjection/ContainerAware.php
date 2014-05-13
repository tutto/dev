<?php

namespace Tutto\SecurityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author fluke.kuczwa@gmail.com
 */
class ContainerAware implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * @return ContainerInterface
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
