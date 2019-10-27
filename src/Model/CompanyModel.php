<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


class CompanyModel implements \JsonSerializable
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
     * @var $nip
     */
    private $nip;

    /**
     * @var $regon
     */
    private $regon;

    /**
     * @var $krs
     */
    private $krs;

    /**
     * @var $address
     */
    private $address;

    /**
     * @var $employees
     */
    private $employees;

    /**
     * @var $capital
     */
    private $capital;

    /**
     * @var $yearOfOperation
     */
    private $yearOfOperation;

    /**
     * @var $description
     */
    private $description;

    public function __construct(
        $id, $name, $nip, $regon, $krs = null,
        $address = null, $employees = null, $capital = null,
        $yearOfOperation = null, $description = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->nip = $nip;
        $this->regon = $regon;
        $this->krs = $krs;
        $this->address = $address;
        $this->employees = $employees;
        $this->capital = $capital;
        $this->yearOfOperation = $yearOfOperation;
        $this->description = $description;
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

    public function getNip() {
        return $this->nip;
    }

    public function setNip($nip) {
        $this->nip = $nip;

        return $this;
    }

    public function getRegon() {
        return $this->regon;
    }

    public function setRegon($regon) {
        $this->regon = $regon;

        return $this;
    }

    public function getKrs() {
        return $this->krs;
    }

    public function setKrs($krs) {
        $this->krs = $krs;

        return $this;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    public function getEmployees() {
        return $this->employees;
    }

    public function setEmployees($employees) {
        $this->employees = $employees;

        return $this;
    }

    public function getCapital() {
        return $this->capital;
    }

    public function setCapital($capital) {
        $this->capital = $capital;

        return $this;
    }

    public function getYearOfOperation() {
        return $this->yearOfOperation;
    }

    public function setYearOfOperation($yearOfOperation) {
        $this->yearOfOperation = $yearOfOperation;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;

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
            'nip' => $this->getNip(),
            'regon' => $this->getRegon(),
            'krs' => $this->getKrs(),
            'address' => $this->getAddress(),
            'employees' => $this->getEmployess(),
            'capital' => $this->getCapital(),
            'yearOfOperation' => $this->getYearOfOperation(),
            'description' => $this->getDescription()
        ];
    }
}
