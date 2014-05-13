<?php

namespace Tutto\SecurityBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author fluke.kuczwa@gmail.com
 */
class RoleRepository extends EntityRepository {
    public function getByName($name) {
        return $this->findOneBy(array(
            'name' => addslashes($name)
        ));
    }
}
