<?php

namespace Tutto\SecurityBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tutto\SecurityBundle\Entity\Account;
use Tutto\SecurityBundle\Entity\PrivilegeControl;

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

    /**
     * @param Account $account
     * @param $control
     * @return int
     */
    public function hasPrivilegeControl(Account $account, $control) {
       $query = $this->createQueryBuilder('a')
                ->join('a.privilegeControls', 'p')
                ->andWhere("p.name = '{$control}' AND ".'p.status = 0')
                ->andWhere("a.id = {$account->getId()}")
                ->select('a');

       return $query->getQuery()->getSingleResult();
    }
} 