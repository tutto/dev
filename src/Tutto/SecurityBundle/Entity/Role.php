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
    const GUEST   = 'GUEST';
    const MEMBER  = 'MEMBER';
    const CLIENT  = 'CLIENT';
    const WORKER  = 'WORKER';
    const ADVISOR = 'ADVISOR';
    const ADMIN   = 'ADMIN';
    
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
     * @ORM\Column(length=255, unique=true)
     *
     * @var string
     */
    protected $name = null;
    
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
     * @param Role $role
     * @return bool
     */
    public function isAllowed(Role $role) {
        if($this->getId() === $role->getId()) {
            return true;
        } else {
            if (($parent = $this->getParent()) instanceof Role) {
                return $parent->isAllowed($role);
            }
        }

        return false;
    }
}
