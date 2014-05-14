<?php

namespace Tutto\SecurityBundle\Configuration;

use Tutto\SecurityBundle\Configuration\Privilege\PermissionDeniedException;
use Tutto\SecurityBundle\TuttoSecurityBundle;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Repository\RoleRepository;
use Tutto\SecurityBundle\Entity\Rolable;
use Tutto\SecurityBundle\Configuration\Privilege\UserNotLoggedException;
use Tutto\SecurityBundle\Entity\Resource;
use Tutto\SecurityBundle\Repository\ResourceRepository;
use Tutto\SecurityBundle\Entity\Resource\Controller;
use Tutto\SecurityBundle\Entity\Resource\Action;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author fluke.kuczwa@gmail.com
 * 
 * @Annotation
 */
class Privilege {
    const METHOD_ANNOTATION = 'annotation';
    const METHOD_DATABASE   = 'database';

    /**
     * @var string
     */
    private $method = self::METHOD_ANNOTATION;

    /**
     * Session namespace where user is stored.
     *
     * @var string
     */
    private $sessionNamespace;
    
    /**
     * Role name that allow access
     *
     * @var string
     */
    private $role;

    /**
     * @var bool
     */
    private $omit = false;

    /**
     * @param array $params
     * @throws PrivilegeException
     */
    public function __construct($params = array()) {
        //Role or method must be setted.
        if(!isset($params['role']) && !isset($params['method']) && !isset($params['omit'])) {
            $params['method'] = self::METHOD_DATABASE;
        }

        foreach($params as $method => $value) {
            $method = 'set'.ucfirst($method);
            call_user_func(array($this, $method), $value);
        }

        if($this->getSessionNamespace() === null) {
            $this->setSessionNamespace(TuttoSecurityBundle::$sessionNamespace);
        }
    }
    
    /**
     * @param string $role
     */
    public function setRole($role) {
        $this->role = $role;
    }
    
    /**
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param $sessionNamespace
     */
    public function setSessionNamespace($sessionNamespace) {
        $this->sessionNamespace = $sessionNamespace;
    }

    /**
     * @return string
     */
    public function getSessionNamespace() {
        return $this->sessionNamespace;
    }

    /**
     * @return boolean
     */
    public function isOmit() {
        return $this->omit;
    }

    /**
     * @param boolean $omit
     */
    public function setOmit($omit) {
        $this->omit = (boolean) $omit;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @param ContainerInterface $container
     * @return bool
     * @throws PrivilegeException
     * @throws PermissionDeniedException
     * @throws UserNotLoggedException
     */
    public function checkPrivilege(ContainerInterface $container) {
        //If is true then not check privileges.
        if($this->isOmit()) {
            return true;
        }

        //User must be logged to check privileges.
        if($this->getUser() === null) {
            throw new UserNotLoggedException('User is not logged yet.');
        }

        /** @var RoleRepository $roleRepository */
        $roleRepository = $container->get('doctrine')->getRepository(Role::class);
        $parts = $this->getControllerAndAction($container->get('request'));

        if($this->getMethod() === self::METHOD_DATABASE) {
            /** @var ResourceRepository $resourceRepository */
            $resourceRepository = $container->get('doctrine')->getRepository(Resource::class);

            /** @var Controller $controller */
            if(!($controller = $resourceRepository->getController($parts[0])) instanceof Controller) {
                throw new PermissionDeniedException("Controller resource: '{$parts[0]}' not found.");
            }

            /** @var Rolable $action */
            if(!($action = $controller->getAction($parts[1])) instanceof Action) {
                throw new PermissionDeniedException("Action resource: '{$parts[1]}' not found");
            }

            $resourceRole = $action->getRole();
        } else {
            $resourceRole = $roleRepository->getByName($this->getRole());
        }

        return $roleRepository->getByName($this->getUser()->getRole())->isAllowedTo($resourceRole);
    }

    /**
     * @return mixed
     * @throws PrivilegeException
     */
    private function getUser() {
        $session = new Session();
        if($session->has($this->getSessionNamespace())) {
            $user = $session->get($this->getSessionNamespace());
            if(!$user instanceof Rolable) {
                throw new PrivilegeException('User not implements interface name: '.Rolable::class);
            }

            return $user;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getControllerAndAction(Request $request) {
        return explode('::', $request->get('_controller'));
    }
}