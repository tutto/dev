<?php

namespace Tutto\SecurityBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tutto\SecurityBundle\Entity\Account;

/**
 * Class AccountRepository
 * @package Tutto\SecurityBundle\Repository
 */
class AccountRepository extends EntityRepository {
    /**
     * @param int    $id
     * @param string $email
     * @return null|Account
     */
    public function get($id, $email) {
        return $this->findOneBy(array(
            'id'    => (int) $id,
            'email' => addslashes($email)
        ));
    }

    /**
     * @param array $criteria
     * @return null|Account
     */
    public function getBy(array $criteria) {
        return $this->findOneBy($criteria);
    }
} 