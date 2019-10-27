<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-19
 * Time: 14:55
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;


/**
 * @ORM\Embeddable
 */
class CompanyData
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $nip;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $regon;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $krs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $capital;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $employees;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearOfOperation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): self
    {
        $this->nip = $nip;

        return $this;
    }

    public function getRegon(): ?string
    {
        return $this->regon;
    }

    public function setRegon(string $regon): self
    {
        $this->regon = $regon;

        return $this;
    }

    public function getKrs(): ?string
    {
        return $this->krs;
    }

    public function setKrs(string $krs): self
    {
        $this->krs = $krs;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCapital(): ?float
    {
        return $this->capital;
    }

    public function setCapital(?float $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getEmployees(): ?int
    {
        return $this->employees;
    }

    public function setEmployees(?int $employees): self
    {
        $this->employees = $employees;

        return $this;
    }

    public function getYearOfOperation(): ?int
    {
        return $this->yearOfOperation;
    }

    public function setYearOfOperation(?int $yearOfOperation): self
    {
        $this->yearOfOperation = $yearOfOperation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}