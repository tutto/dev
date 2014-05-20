<?php

namespace Tutto\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 * @package Tutto\AccountBundle\Entity
 *
 * @ORM\Entity()
 */
class Address {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $country = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $city = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $voivodeship = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $postalCode = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $street = null;

    /**
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPostalCode() {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street) {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getVoivodeship() {
        return $this->voivodeship;
    }

    /**
     * @param string $voivodeship
     */
    public function setVoivodeship($voivodeship) {
        $this->voivodeship = $voivodeship;
    }
} 