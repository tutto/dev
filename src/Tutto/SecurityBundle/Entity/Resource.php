<?php

namespace Tutto\SecurityBundle\Entity;

use Tutto\SecurityBundle\Entity\Rolable;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Krzysztof Januś <fluke.kuczwa@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tutto\SecurityBundle\Repository\ResourceRepository")
 * @ORM\Table(name="resources")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "controller" = "Tutto\SecurityBundle\Entity\Resource\Controller",
 *      "action"     = "Tutto\SecurityBundle\Entity\Resource\Action"
 * })
 */
class Resource implements Rolable {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Resource", inversedBy="children", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     *
     * @var Resource
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="parent", cascade={"persist"}, fetch="EAGER")
     *
     * @var ArrayCollection
     */
    protected $children;
    
    /**
     * @ORM\OneToOne(targetEntity="Role", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="role", referencedColumnName="id")
     *
     * @var Role
     */
    protected $role;
    
    /**
     * @ORM\Column(length=255)
     * 
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=255)
     *
     * @var string
     */
    protected $title = null;
    
    /**
     * @ORM\Column(length=255)
     *
     * @var string
     */
    protected $keywords = null;
    
    /**
     * @ORM\Column(length=255)
     *
     * @var string
     */
    protected $description = null;
    
    /**
     * @ORM\Column(length=255)
     *
     * @var string
     */
    protected $version = "1.0.0";
    
    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $allowRecursion = true;
    
    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $isActive = true;

    /**
     *
     */
    public function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return Resource
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @return bool
     */
    public function getAllowRecursion() {
        return $this->allowRecursion;
    }

    /**
     * @return bool
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * @param Resource $parent
     * @return Resource
     */
    public function setParent(Resource $parent) {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @param Resource $resource
     * @return Resource
     */
    public function addChild(Resource $resource) {
        $resource->setParent($this);
        $this->getChildren()->add($resource);
        return $this;
    }

    /**
     * @param Role $role
     * @return Resource
     */
    public function setRole(Role $role) {
        $this->role = $role;
        return $this;
    }

    /**
     * @param $name
     * @return Resource
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $title
     * @return Resource
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @param $keywords
     * @return Resource
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @param $description
     * @return Resource
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param $version
     * @return Resource
     */
    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    /**
     * @param $allowRecursion
     * @return Resource
     */
    public function setAllowRecursion($allowRecursion) {
        $this->allowRecursion = (bool) $allowRecursion;
        return $this;
    }

    /**
     * @param $isActive
     * @return Resource
     */
    public function setIsActive($isActive) {
        $this->isActive = (bool) $isActive;
        return $this;
    }
}
