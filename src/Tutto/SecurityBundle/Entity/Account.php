<?php

namespace Tutto\SecurityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
     *
     * @var Person|null
     */
    protected $person = null;

    /**
     * @ORM\OneToOne(targetEntity="Tutto\SecurityBundle\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     *
     * @var Role
     */
    protected $role;

    /**
     * @ORM\ManyToMany(targetEntity="Tutto\SecurityBundle\Entity\PrivilegeControl")
     * @ORM\JoinTable(name="accounts_has_privilege_controls",
     *      joinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="privilege_control_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    protected $privilegeControls;

    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setPerson(new Person());
        $this->privilegeControls = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPrivilegeControls() {
        return $this->privilegeControls;
    }

    /**
     * @param PrivilegeControl $privilege
     */
    public function addPrivilegeControl(PrivilegeControl $privilege) {
        $this->getPrivilegeControls()[] = $privilege;
    }

    /**
     * @param PrivilegeControl $privilege
     * @return bool
     */
    public function hasPrivilegeControl(PrivilegeControl $privilege) {
        return $this->getPrivilegeControls()->contains($privilege);
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
     * @param array $roles
     * @return $this|void
     */
    public function setRoles(array $roles) {
        if(!empty($roles) && isset($roles[0])) {
            $this->setRole($roles[0]);
        }
    }

    /**
     * @param Role $role
     * @return void
     */
    public function addRole($role) {
        $this->setRole($role);
    }

    /**
     * @return Role
     */
    public function getRoles() {
        return array(
            $this->getRole()->getName()
        );
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