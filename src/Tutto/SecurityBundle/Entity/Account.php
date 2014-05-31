<?php

namespace Tutto\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Tutto\SecurityBundle\Entity\AbstractAccount;
use Tutto\FrontendBundle\Entity\Person;

/**
 * Class Account
 * @package Tutto\SecurityBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Tutto\SecurityBundle\Repository\AccountRepository")
 * @ORM\Table(name="accounts")
 */
class Account extends BaseUser {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Tutto\FrontendBundle\Entity\Person", cascade={"persist"})
     * @ORM\JoinColumn(name="person", referencedColumnName="id")
     *
     * @var Person|null
     */
    protected $person = null;

    /**
     * @ORM\OneToOne(targetEntity="Tutto\SecurityBundle\Entity\Role")
     * @ORM\JoinColumn(name="role", referencedColumnName="id")
     *
     * @var Role
     */
    protected $role;

    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setPerson(new Person());
    }

    /**
     * @param Person $person
     * @return Account
     */
    public function setPerson(Person $person = null) {
        $this->person = $person;

        return $this;
    }

    /**
     * @return null|Person
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * @param string $email
     * @return Account
     */
    public function setEmail($email) {
        $this->email = $email;
        $this->setUsername($email);

        return $this;
    }

    /**
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role) {
        $this->role = $role;
    }
} 