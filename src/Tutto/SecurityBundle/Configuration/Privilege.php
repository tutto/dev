<?php

namespace Tutto\SecurityBundle\Configuration;

use Exception;

/**
 * @author fluke.kuczwa@gmail.com
 * 
 * @Annotation
 */
class Privilege {
    const CHECK_TYPE_ANNOTATION = 'ANNOTATION';
    const CHECK_TYPE_DATABASE   = 'DATABASE';
    
    /**
     * @var string
     */
    private $role;
    
    /**
     * @var string
     */
    private $type = self::CHECK_TYPE_ANNOTATION;
    
    public function __construct($params = array()) {
        if(!isset($params['role'])) { throw new PrivilegeException('Privilege must have role.'); }
        $this->setRole($params['role']);
        
        if(isset($params['type'])) {
            $this->setCheckType($params['type']);
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
     * @param string $type
     * @throws PrivilegeException
     */
    public function setCheckType($type = self::CHECK_TYPE_ANNOTATION) {
        switch($type) {
            case self::CHECK_TYPE_ANNOTATION :
            case self::CHECK_TYPE_DATABASE   :
                $this->type = $type;
                return $this;
            default : throw new PrivilegeException("Type: '{$type}' not defined.");
        }
    }
    
    /**
     * @return string
     */
    public function getCheckType() {
        return $this->type;
    }
}

class PrivilegeException extends Exception {}