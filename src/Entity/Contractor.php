<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractorRepository")
 */
class Contractor
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Embedded(class = "CompanyData", columnPrefix = "company_")
     */
    private $companyData;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractorOffer", mappedBy="contractor")
     */
    private $contractorOffers;

    public function __construct()
    {
        $this->companyData = new CompanyData();
        $this->contractorOffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCompanyData(): ?CompanyData
    {
        return $this->companyData;
    }

    public function setCompanyData(CompanyData $companyData): self
    {
        $this->companyData = $companyData;

        return $this;
    }

    /**
     * @return Collection|ContractorOffer[]
     */
    public function getContractorOffers(): Collection
    {
        return $this->contractorOffers;
    }

    public function addContractorOffer(ContractorOffer $contractorOffer): self
    {
        if (!$this->contractorOffers->contains($contractorOffer)) {
            $this->contractorOffers[] = $contractorOffer;
            $contractorOffer->setContractor($this);
        }

        return $this;
    }

    public function removeContractorOffer(ContractorOffer $contractorOffer): self
    {
        if ($this->contractorOffers->contains($contractorOffer)) {
            $this->contractorOffers->removeElement($contractorOffer);
            // set the owning side to null (unless already changed)
            if ($contractorOffer->getContractor() === $this) {
                $contractorOffer->setContractor(null);
            }
        }

        return $this;
    }
}
