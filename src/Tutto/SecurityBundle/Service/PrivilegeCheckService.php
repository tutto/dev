<?php

namespace Tutto\SecurityBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck\PermissionDeniedException;
use Tutto\SecurityBundle\Entity\Rolable;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Service\PrivilegeCheckService\PrivilegeCheckServiceException;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerAware;

use Doctrine\Common\Annotations\AnnotationReader;

use ReflectionObject;
use Tutto\SecurityBundle\TuttoSecurityBundle;

/**
 * @author fluke.kuczwa@gmail.com
 */
class PrivilegeCheckService extends ContainerAware {
    /**
     * @param FilterControllerEvent $event
     * @throws PrivilegeCheckService\PrivilegeCheckServiceException
     * @throws \Tutto\SecurityBundle\Configuration\PrivilegeCheck\PermissionDeniedException
     */
    public function init(FilterControllerEvent $event) {
        //Only master request, skip exception messages to render proper view to
        //debug application exceptions
        if(!$event->isMasterRequest()) {
            return true;
        }

        $controllerArray = $event->getController();
        //Check if in array are controller and action
        if(!isset($controllerArray[0]) && !isset($controllerArray[1])) {
            return false;
        }

        /* @var $controller Controller */
        $controller = $controllerArray[0];
        $action     = $controllerArray[1];
        if(!$controller instanceof Controller) {
            return false;
        }

        //Check privilege for action
        if(($privilege = $this->getPrivilegeAnnotationForAction($controller, $action))) {
            $privilege->setContainer($this->container);
            if($privilege->checkPrivilege()) {
                return true;
            } else {
                throw new PermissionDeniedException("Deny for: '{$action}'");
            }
        }

        //Check privilege for controller if action has not annotation
        if(($privilege = $this->getPrivilegeAnnotationForController($controller))) {
            $privilege->setContainer($this->container);
            if($privilege->checkPrivilege()) {
                return true;
            } else {
                throw new PermissionDeniedException("Deny for controller: '".get_class($controller)."' and action: '{$action}'");
            }
        }

        //If annotation was not found either in controller nor action, throw exception.
        throw new PrivilegeCheckServiceException("Controller: '".get_class($controller)."' and action:
                                          '{$action}' do not implements annotation '".PrivilegeCheck::class."'");
    }

    /**
     * @param Controller $controller
     * @return PrivilegeCheck
     */
    private function getPrivilegeAnnotationForController(Controller $controller) {
        $object = new ReflectionObject($controller);
        $reader = new AnnotationReader();

        return $this->getPrivilegeAnnotation($reader->getClassAnnotations($object));
    }

    /**
     * @param Controller $controller
     * @param $action
     * @return PrivilegeCheck
     */
    private function getPrivilegeAnnotationForAction(Controller $controller, $action) {
        $object = new ReflectionObject($controller);
        $reader = new AnnotationReader();

        if($object->hasMethod($action)) {
            return $this->getPrivilegeAnnotation($reader->getMethodAnnotations($object->getMethod($action)));
        }
    }

    /**
     * @param array $annotations
     * @return PrivilegeCheck
     */
    private function getPrivilegeAnnotation(array $annotations) {
        foreach($annotations as $annotatin) {
            if(is_object($annotatin) && $annotatin instanceof PrivilegeCheck) {
                return $annotatin;
            }
        }
    }
}