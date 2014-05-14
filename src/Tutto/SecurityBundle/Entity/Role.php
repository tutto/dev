<?php

namespace Tutto\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author fluke.kuczwa@gmail.com
 * 
 * @ORM\Entity(repositoryClass="Tutto\SecurityBundle\Repository\RoleRepository")
 * @ORM\Table(name="roles")
 */
class Role {
    const ROLE_GUEST         = 'guest';
    const ROLE_MEMBER        = 'member';
    const ROLE_CLIENT        = 'client';
    const ROLE_WORKER        = 'worker';
    const ROLE_ADVISOR       = 'advisor';
    const ROLE_ADMINISTRATOR = 'administrator';
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     *
     * @var Role|null
     */
    protected $parent = null;
    
    /**
     * @ORM\Column(length=255)
     *
     * @var string
     */
    protected $name = null;
    
    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $level = 0;
    
    /**
     * @ORM\OneToMany(targetEntity="Role", mappedBy="parent", cascade={"persist"})
     *
     * @var ArrayCollection
     */
    protected $children;
    
    /**
     * @param string $name
     */
    public function __construct($name = null) {
        $this->children = new ArrayCollection();
        $this->setName($name);
    }
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return Role
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * @param Role $parent
     * @return Role
     */
    public function setParent(Role $parent) {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName($name) {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * @param int $level
     * @return Role
     */
    public function setLevel($level) {
        $this->level = (int) $level;
        return $this;
    }
    
    /**
     * Check if role level of this object is grather or equal
     * then setted as param @role
     * 
     * For example:
     *    this role has level: 60
     *    setted role $role has level: 30
     *    We check: if 60 >= 30 --> this role has access.
     * 
     * @param Role $role
     * @return boolean
     */
    public function isAllowedTo(Role $role) {
        return $this->getLevel() >= $role->getLevel();
    }
}
