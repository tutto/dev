<?php

namespace Tutto\SecurityBundle\Configuration;

use Tutto\CommonBundle\DependencyInjection\AbstractContainerAware;
use Tutto\SecurityBundle\Configuration\PrivilegeCheck\UserNotLoggedException;
use Tutto\SecurityBundle\Entity\Account;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Repository\RoleRepository;
use Tutto\SecurityBundle\Entity\Resource;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author fluke.kuczwa@gmail.com
 * 
 * @Annotation
 */
class PrivilegeCheck extends AbstractContainerAware {
    const METHOD_ANNOTATION = 'annotation';
    const METHOD_DATABASE   = 'database';

    /**
     * @var string
     */
    private $method = self::METHOD_ANNOTATION;
    
    /**
     * Role name that allow access
     *
     * @var array
     */
    private $roles;

    /**
     * @var bool
     */
    private $omit = false;

    /**
     * @param array $params
     */
    public function __construct($params = array()) {
        //Role or method must be setted or is omit. If is not setted,
        //check privileges from database
        if(!isset($params['roles']) && !isset($params['method']) && !isset($params['omit'])) {
            $params['method'] = self::METHOD_DATABASE;
        }

        foreach($params as $method => $value) {
            $method = 'set'.ucfirst($method);
            call_user_func(array($this, $method), $value);
        }
    }
    
    /**
     * @param array $role
     */
    public function setRoles(array $role) {
        $this->roles = $role;
    }
    
    /**
     * @return array
     */
    public function getRoles() {
        return $this->roles;
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
     * @return bool
     * @throws PrivilegeCheckException
     * @throws PrivilegeCheck\UserNotLoggedException
     */
    public function checkPrivilege() {
        //If is true then not check privileges.
        if($this->isOmit()) {
            return true;
        }

        //User must be logged to check privileges.
        if(!$this->getAccount() instanceof Account) {
            throw new UserNotLoggedException('User is not logged.');
        }

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);

        if($this->getMethod() === self::METHOD_DATABASE) {
            throw new PrivilegeCheckException("Method: DATABASE not implemented yet");
        } elseif ($this->getMethod() === self::METHOD_ANNOTATION) {
        } else {
            throw new PrivilegeCheckException("Method not found.");
        }

        $accountRole = $this->getAccount()->getRole();
        foreach ($this->getRoles() as $role) {
            if (($role = $roleRepository->getByName($role)) instanceof Role) {
                if ($accountRole->isAllowed($role)) {
                    return true;
                }
            }
        }

        return false;
    }
}