<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


class ContractorModel implements \JsonSerializable
{
    /**
     * @var $id
     */
    private $id;

    /**
     * @var $name
     */
    private $name;

    /**
     * @var $surname
     */
    private $surname;

    /**
     * @var $surname
     */
    private $email;

    /**
     * @var $companyName
     */
    private $companyName;

    /**
     * @var $companyNip
     */
    private $companyNip;

    /**
     * @var $companyRegon
     */
    private $companyRegon;

    /**
     * @var $companyKrs
     */
    private $companyKrs;

    /**
     * @var $companyAddress
     */
    private $companyAddress;

    /**
     * @var $companyEmployees
     */
    private $companyEmployees;

    /**
     * @var $companyCapital
     */
    private $companyCapital;

    /**
     * @var $companyYearOfOperation
     */
    private $companyYearOfOperation;

    /**
     * @var $companyDescription
     */
    private $companyDescription;

    /**
     * @var $contractorOffers[]
     */
    private $contractorOffers;


    public function __construct(
        $id, $name, $surname, $email, $companyName, $companyNip, $companyRegon, $companyKrs, $companyAddress,
        $companyEmployees, $companyCapital, $companyYearOfOperation, $companyDescription, $contractorOffers = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->companyName = $companyName;
        $this->companyNip = $companyNip;
        $this->companyRegon = $companyRegon;
        $this->companyKrs = $companyKrs;
        $this->companyAddress = $companyAddress;
        $this->companyEmployees = $companyEmployees;
        $this->companyCapital = $companyCapital;
        $this->companyYearOfOperation = $companyYearOfOperation;
        $this->companyDescription = $companyDescription;
        $this->contractorOffers = $contractorOffers;
    }

    public function getId() {
        return $this->id;
    }

    public function setId() {
        $this->id;

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyNip() {
        return $this->companyNip;
    }

    public function setCompanyNip($companyNip) {
        $this->companyNip = $companyNip;

        return $this;
    }

    public function getCompanyRegon() {
        return $this->companyName;
    }

    public function setCompanyRegon($companyRegon) {
        $this->companyRegon = $companyRegon;

        return $this;
    }

    public function getCompanyKrs() {
        return $this->companyName;
    }

    public function setCompanyKrs($companyKrs) {
        $this->companyKrs = $companyKrs;

        return $this;
    }

    public function getCompanyAddress() {
        return $this->companyAddress;
    }

    public function setCompanyAddress($companyAddress) {
        $this->companyAddress = $companyAddress;

        return $this;
    }

    public function getCompanyEmployees() {
        return $this->companyEmployees;
    }

    public function setCompanyEmployees($companyEmployees) {
        $this->companyEmployees = $companyEmployees;

        return $this;
    }

    public function getCompanyCapital() {
        return $this->companyCapital;
    }

    public function setCompanyCapital($companyCapital) {
        $this->companyCapital = $companyCapital;

        return $this;
    }

    public function getCompanyYearOfOperation() {
        return $this->companyYearOfOperation;
    }

    public function setCompanyYearOfOperation($companyYearOfOperation) {
        $this->companyYearOfOperation = $companyYearOfOperation;

        return $this;
    }

    public function getCompanyDescription() {
        return $this->companyDescription;
    }

    public function setCompanyDescription($companyDescription) {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    public function getContractorOffers() {
        return $this->contractorOffers;
    }

    public function setContractorOffers($contractorOffers) {
        $this->contractorOffers = $contractorOffers;

        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'email' => $this->getEmail(),
            'companyName' => $this->getCompanyName(),
            'companyNip' => $this->getCompanyNip(),
            'companyRegon' => $this->getCompanyRegon(),
            'companyKrs' => $this->getCompanyKrs(),
            'companyAddress' => $this->getCompanyAddress(),
            'companyEmployees' => $this->getCompanyEmployees(),
            'companyCapital' => $this->getCompanyCapital(),
            'companyYearOfOperation' => $this->getCompanyYearOfOperation(),
            'companyDescription' => $this->getCompanyDescription(),
            'contractorOffers' => $this->getContractorOffers(),
        ];
    }
}