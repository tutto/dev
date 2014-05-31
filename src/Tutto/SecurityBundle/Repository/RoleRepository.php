<?php

namespace Tutto\SecurityBundle\Repository;

use Doctrine\ORM\NoResultException;
use Tutto\SecurityBundle\Entity\Role;

use Doctrine\ORM\EntityRepository;

/**
 * @author fluke.kuczwa@gmail.com
 */
class RoleRepository extends EntityRepository {
    /**
     * @var array
     */
    private $roles = array();

    /**
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @return array
     */
    public function getAll() {
        if (!$this->isInitialized) {
            $this->isInitialized = true;
            $this->roles = $this->findAll();
        }

        return $this->roles;
    }

    /**
     * @param $name
     * @return null|Role
     */
    public function getByName($name) {
        foreach ($this->getAll() as $role) {
            if($role->getName() === $name) {
                return $role;
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id) {
        foreach ($this->getAll() as $role) {
            if($role->getId() === (int) $id) {
                return $role;
            }
        }
    }
}
