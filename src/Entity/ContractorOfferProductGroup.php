<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractorOfferProductGroupRepository")
 */
class ContractorOfferProductGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContractorOffer", inversedBy="contractorOfferProductGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contractorOffer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductGroup", inversedBy="contractorOfferProductGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productGroup;

    /**
     * @ORM\Column(type="integer")
     */
    private $deliveryTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $guaranteePeriod;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractorOfferProductGroupProduct", mappedBy="contractorOfferProductGroup")
     */
    private $contractorOfferProductGroupProducts;

    public function __construct()
    {
        $this->contractorOfferProductGroupProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractorOffer(): ?ContractorOffer
    {
        return $this->contractorOffer;
    }

    public function setContractorOffer(?ContractorOffer $contractorOffer): self
    {
        $this->contractorOffer = $contractorOffer;

        return $this;
    }

    public function getProductGroup(): ?ProductGroup
    {
        return $this->productGroup;
    }

    public function setProductGroup(?ProductGroup $productGroup): self
    {
        if ($this->contractorOffer->getAuction()->getProductGroups()->contains($productGroup)) {
            $this->productGroup = $productGroup;
        }

        return $this;
    }

    public function getDeliveryTime(): ?int
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime(int $deliveryTime): self
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    public function getGuaranteePeriod(): ?int
    {
        return $this->guaranteePeriod;
    }

    public function setGuaranteePeriod(int $guaranteePeriod): self
    {
        $this->guaranteePeriod = $guaranteePeriod;

        return $this;
    }

    /**
     * @return Collection|ContractorOfferProductGroupProduct[]
     */
    public function getContractorOfferProductGroupProducts(): Collection
    {
        return $this->contractorOfferProductGroupProducts;
    }

    public function addContractorOfferProductGroupProduct(ContractorOfferProductGroupProduct $contractorOfferProductGroupProduct): self
    {
        if (!$this->contractorOfferProductGroupProducts->contains($contractorOfferProductGroupProduct)) {
            $this->contractorOfferProductGroupProducts[] = $contractorOfferProductGroupProduct;
            $contractorOfferProductGroupProduct->setContractorOfferProductGroup($this);
        }

        return $this;
    }

    public function removeContractorOfferProductGroupProduct(ContractorOfferProductGroupProduct $contractorOfferProductGroupProduct): self
    {
        if ($this->contractorOfferProductGroupProducts->contains($contractorOfferProductGroupProduct)) {
            $this->contractorOfferProductGroupProducts->removeElement($contractorOfferProductGroupProduct);
            // set the owning side to null (unless already changed)
            if ($contractorOfferProductGroupProduct->getContractorOfferProductGroup() === $this) {
                $contractorOfferProductGroupProduct->setContractorOfferProductGroup(null);
            }
        }

        return $this;
    }
}
