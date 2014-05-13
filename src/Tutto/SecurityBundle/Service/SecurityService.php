<?php

namespace Tutto\SecurityBundle\Service;

use Tutto\SecurityBundle\DependencyInjection\ContainerAware;
use Tutto\SecurityBundle\Service\Security\SecurityServiceException;
use Tutto\SecurityBundle\Service\Security\PermissionDeniedException;
use Tutto\SecurityBundle\Service\Security\UserNotLoggedException;
use Tutto\SecurityBundle\Repository\RoleRepository;
use Tutto\SecurityBundle\TuttoSecurityBundle;
use Tutto\SecurityBundle\Entity\Rolable;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Configuration\Privilege;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Intl\Exception\NotImplementedException;

use Doctrine\Common\Annotations\AnnotationReader;

use ReflectionObject;
use LogicException;

/**
 * @author fluke.kuczwa@gmail.com
 */
class SecurityService extends ContainerAware {
    /**
     * @param FilterControllerEvent $event
     * @return boolean
     * @throws LogicException
     * @throws SecurityServiceException
     * @throws PermissionDeniedException
     */
    public function init(FilterControllerEvent $event) {
        //Only master request, skip exception messages to render proper view to
        //debug application exceptions
        if(!$event->isMasterRequest()) {
            return true;
        }
        
        //Check if controller is array type({0: controllerInstance, 1: actionName})
        if(!is_array($event->getController())) {
            throw new LogicException("Controller is not array.");
        }
        
        $controllerArray = $event->getController();
        //Check if controller is Controller instance.
        if(!isset($controllerArray[0]) || !$controllerArray[0] instanceof Controller) {
            throw new SecurityServiceException('Controller not found');
        }
        
        //Check if action is defined.
        if(!isset($controllerArray[1])) {
            throw new SecurityServiceException('Action not found');
        }
        
        /* @var $controller Controller */
        $controller = $controllerArray[0];
        $action     = $controllerArray[1];
        
        //if action has annotation, check privileges
        $hasPrivilegeAnnotation = false;
        if(($privilege = $this->getActionPrivilegeAnnotation($controller, $action)) !== null) {
            $hasPrivilegeAnnotation = true;
            if($this->checkPrivileges($privilege)) {
                return true;
            } else {
                throw new PermissionDeniedException("Permission denied for action: '{$action}'");
            }
        }
        
        //if action has not annotation but controller has, check privileges
        if(($privilege = $this->getControllerPrivilegeAnnotation($controller)) !== null && !$hasPrivilegeAnnotation) {
            if($this->checkPrivileges($privilege)) {
                return true;
            } else {
                throw new PermissionDeniedException("Permission denied for controller: '".get_class($controller)."' and action: '{$action}'");
            }
        }
        
        //If action and controller have not annotation then throw exception.
        throw new SecurityServiceException('Controller: '.get_class($controller).' or action '.$action.' has not annotation @Security.');
    }
    
    /**
     * @param array $annotations
     * @return Privilege
     */
    private function getPrivilegeAnnotation(array $annotations) {
        foreach($annotations as $annotatin) {
            if(is_object($annotatin) && $annotatin instanceof Privilege) {
                return $annotatin;
            }
        }
    }
    
    /**
     * @param Controller $controller
     * @return Privilege
     */
    private function getControllerPrivilegeAnnotation(Controller $controller) {
        $object = new ReflectionObject($controller);
        $reader = new AnnotationReader();
        
        return $this->getPrivilegeAnnotation($reader->getClassAnnotations($object));
    }
    
    /**
     * @param Controller $controller
     * @param string $action
     * @return null|Privilege
     */
    private function getActionPrivilegeAnnotation(Controller $controller, $action) {
        $object = new ReflectionObject($controller);
        $reader = new AnnotationReader();
        
        if($object->hasMethod($action)) {
            $method = $object->getMethod($action);
            return $this->getPrivilegeAnnotation($reader->getMethodAnnotations($method));
        }
    }
    
    /**
     * @param \Tutto\SecurityBundle\Configuration\Privilege $privilege
     * @return boolean
     * @throws SecurityServiceException
     * @throws UserNotLoggedException
     */
    private function checkPrivileges(Privilege $privilege) {
        $Session = new Session();
        
        if($Session->has(TuttoSecurityBundle::$sessionNamespace)) {
            /* @var $user Rolable */
            $user = $Session->get(TuttoSecurityBundle::$sessionNamespace);
            if($user instanceof Rolable) {
                $userRole = $this->getRole($user->getRole());
                $resRole  = $this->getRole($privilege->getRole());
                
                if($userRole instanceof Role) {
                    $type = $privilege->getCheckType();
                    switch($type) {
                        case Privilege::CHECK_TYPE_ANNOTATION : 
                            return $userRole->isAllowedTo($resRole);
                        case Privilege::CHECK_TYPE_DATABASE :
                            throw new NotImplementedException("");
                        default : 
                            throw new SecurityServiceException("Type: '{$type}' not found."); 
                    }
                } else {
                    throw new SecurityServiceException('Role is not type: "'.Role::class.'". Setted type: '.  gettype($userRole));
                }
            } else {
                throw new SecurityServiceException('User not implements interface: "'.Rolable::class.'"');
            }
        } else {
            throw new UserNotLoggedException("User is not logged.");
        }
    }
    
    /**
     * @param string|Role $name
     * @return Role
     */
    private function getRole($name) {
        if(is_string($name)) {
            /* @var $roleRepository RoleRepository */
            $roleRepository = $this->getContainer()->get('doctrine')->getRepository(Role::class);
            return $roleRepository->getByName($name);
        } elseif(is_object($name) && $name instanceof Role) {
            return $name;
        } else {
            throw new LogicException('Role not found.');
        }
    }
}


class TestAccount implements Rolable {
    private $c;
    
    public function __construct($c) {
        $this->c = $c;
    }
    public function getRole() {
        return Role::ROLE_ADMINISTRATOR;
    }
}