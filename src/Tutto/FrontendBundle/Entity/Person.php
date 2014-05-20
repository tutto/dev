<?php

namespace Tutto\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Tutto\FrontendBundle\Entity\Address;

use DateTime;

/**
 * Class Person
 * @package Tutto\AccountBundle\Entity
 *
 * @ORM\Entity()
 */
class Person {
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
    protected $firstname = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $middlename = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $lastname = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @var string
     */
    protected $birthday = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $birthdayPlace = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $taxNumber = null;

    /**
     * @ORM\Column(type="array")
     *
     * @var array
     */
    protected $phones = null;

    /**
     * @ORM\Column(type="array")
     *
     * @var string
     */
    protected $emails = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $bankAccountNumber = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $bankAccountName = null;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $sameAddress = false;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="correspondenceAddress", referencedColumnName="id")
     *
     * @var Address
     */
    protected $correspondenceAddress = null;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="homeAddress", referencedColumnName="id")
     *
     * @var Address
     */
    protected $homeAddress = null;

    /**
     * todo do zrobienia jest klasa entity: File do której będzie ustawiona relacja oneToOne
     *
     * @var null
     */
    protected $avatar = null;

    /**
     *
     */
    public function __construct() {
        $this->setCorrespondenceAddress(new Address());
        $this->setHomeAddress(new Address());
        $this->birthday = new DateTime();
    }


    /**
     * @return null
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * @param null $avatar
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getBankAccountName() {
        return $this->bankAccountName;
    }

    /**
     * @param string $bankAccountName
     */
    public function setBankAccountName($bankAccountName) {
        $this->bankAccountName = $bankAccountName;
    }

    /**
     * @return string
     */
    public function getBankAccountNumber() {
        return $this->bankAccountNumber;
    }

    /**
     * @param string $bankAccountNumber
     */
    public function setBankAccountNumber($bankAccountNumber) {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    /**
     * @return string
     */
    public function getBirthday() {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getBirthdayPlace() {
        return $this->birthdayPlace;
    }

    /**
     * @param string $birthdayPlace
     */
    public function setBirthdayPlace($birthdayPlace) {
        $this->birthdayPlace = $birthdayPlace;
    }

    /**
     * @return Address
     */
    public function getCorrespondenceAddress() {
        return $this->correspondenceAddress;
    }

    /**
     * @param Address $correspondenceAddress
     */
    public function setCorrespondenceAddress($correspondenceAddress) {
        $this->correspondenceAddress = $correspondenceAddress;
    }

    /**
     * @return string
     */
    public function getEmails() {
        return $this->emails;
    }

    /**
     * @param string $emails
     */
    public function setEmails($emails) {
        $this->emails = $emails;
    }

    /**
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    /**
     * @return Address
     */
    public function getHomeAddress() {
        return $this->homeAddress;
    }

    /**
     * @param Address $homeAddress
     */
    public function setHomeAddress($homeAddress) {
        $this->homeAddress = $homeAddress;
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
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getMiddlename() {
        return $this->middlename;
    }

    /**
     * @param string $middlename
     */
    public function setMiddlename($middlename) {
        $this->middlename = $middlename;
    }

    /**
     * @return array
     */
    public function getPhones() {
        return $this->phones;
    }

    /**
     * @param array $phones
     */
    public function setPhones($phones) {
        $this->phones = $phones;
    }

    /**
     * @return boolean
     */
    public function isSameAddress() {
        return $this->sameAddress;
    }

    /**
     * @param boolean $sameAddress
     */
    public function setSameAddress($sameAddress) {
        $this->sameAddress = $sameAddress;
    }

    /**
     * @return string
     */
    public function getTaxNumber() {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     */
    public function setTaxNumber($taxNumber) {
        $this->taxNumber = $taxNumber;
    }
} 