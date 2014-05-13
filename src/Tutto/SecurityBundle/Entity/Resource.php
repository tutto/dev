<?php
/**
 * Resource
 * 
 * (c) Krzysztof Januś <fluke.kuczwa@gmail.com>
 */
namespace Tutto\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Tutto\SecurityBundle\Entity\Role;

/**
 * Resource
 * 
 * Description:
 * 
 * @author Krzysztof Januś <fluke.kuczwa@gmail.com>
 * @copyright (c) 2013-10-23, Januś Krzysztof
 * @category \
 * @package \
 * @see
 * @version 1.0
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
class Resource {
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
    
    public function getId() {
        return $this->id;
    }

    public function getParent() {
        return $this->parent;
    }
    
    public function getChildren() {
        return $this->children;
    }

    public function getRole() {
        return $this->role;
    }

    public function getName() {
        return $this->name;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getVersion() {
        return $this->version;
    }

    public function getAllowRecursion() {
        return $this->allowRecursion;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setParent(Resource $parent) {
        $this->parent = $parent;
        return $this;
    }
    
    public function addChild(Resource $resource) {
        $this->getChildren()->add($resource);
        return $this;
    }

    public function setRole(Role $role) {
        $this->role = $role;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setKeywords($keywords) {
        $this->keywords = $keywords;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    public function setAllowRecursion($allowRecursion) {
        $this->allowRecursion = $allowRecursion;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }
}
