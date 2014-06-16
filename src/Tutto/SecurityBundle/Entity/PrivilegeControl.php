<?php

namespace Tutto\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTime;

/**
 * @ORM\Entity()
 * @ORM\Table(name="privilege_controls")
 *
 * Class PrivilegeControl
 * @package Tutto\SecurityBundle\Entity
 */
class PrivilegeControl {
    const STATUS_ENABLED  = 1;
    const STATUS_DISABLED = 0;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=255, unique=true)
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $status = 1;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $createdAt;


    public function __construct() {
        $this->createdAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
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
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }
} 