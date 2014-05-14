<?php

namespace Tutto\SecurityBundle\Repository;

use Tutto\SecurityBundle\Entity\Role;

use Doctrine\ORM\EntityRepository;

/**
 * @author fluke.kuczwa@gmail.com
 */
class RoleRepository extends EntityRepository {
    /**
     * @param $name
     * @return null|Role
     */
    public function getByName($name) {
        return $this->findOneBy(array(
            'name' => addslashes($name)
        ));
    }
}
