<?php

namespace Tutto\SecurityBundle\Entity;

use Tutto\SecurityBundle\Entity\Role;

/**
 * @author fluke.kuczwa@gmail.com
 */
interface Rolable {
    /**
     * @return Role
     */
    public function getRole();
}
