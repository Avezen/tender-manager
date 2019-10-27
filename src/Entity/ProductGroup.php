<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductGroupRepository")
 */
class ProductGroup
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
     * @ORM\Column(type="string", length=55)
     */
    private $cpv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $deliveryAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Request", inversedBy="productGroups")
     * @ORM\JoinColumn(nullable=true)
     */
    private $request;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductGroupProduct", mappedBy="productGroup")
     */
    private $productGroupProducts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Auction", mappedBy="productGroups")
     * @ORM\JoinColumn(nullable=true)
     */
    private $auctions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractorOfferProductGroup", mappedBy="productGroup")
     */
    private $contractorOfferProductGroups;


    public function __construct()
    {
        $this->productGroupProducts = new ArrayCollection();
        $this->auctions = new ArrayCollection();
        $this->contractorOfferProductGroups = new ArrayCollection();
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

    public function getCpv(): ?string
    {
        return $this->cpv;
    }

    public function setCpv(string $cpv): self
    {
        $this->cpv = $cpv;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(?Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return Collection|ProductGroupProduct[]
     */
    public function getProductGroupProducts(): Collection
    {
        return $this->productGroupProducts;
    }

    public function addProductGroupProduct(ProductGroupProduct $productGroupProduct): self
    {
        if (!$this->productGroupProducts->contains($productGroupProduct)) {
            $this->productGroupProducts[] = $productGroupProduct;
            $productGroupProduct->setProductGroup($this);
        }

        return $this;
    }

    public function removeProductGroupProduct(ProductGroupProduct $productGroupProduct): self
    {
        if ($this->productGroupProducts->contains($productGroupProduct)) {
            $this->productGroupProducts->removeElement($productGroupProduct);
            // set the owning side to null (unless already changed)
            if ($productGroupProduct->getProductGroup() === $this) {
                $productGroupProduct->setProductGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Auction[]
     */
    public function getAuctions(): Collection
    {
        return $this->auctions;
    }

    public function addAuction(Auction $auction): self
    {
        if (!$this->auctions->contains($auction)) {
            $this->auctions[] = $auction;
            $auction->addProductGroup($this);
        }

        return $this;
    }

    public function removeAuction(Auction $auction): self
    {
        if ($this->auctions->contains($auction)) {
            $this->auctions->removeElement($auction);
            $auction->removeProductGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection|ContractorOfferProductGroup[]
     */
    public function getContractorOfferProductGroups(): Collection
    {
        return $this->contractorOfferProductGroups;
    }

    public function addContractorOfferProductGroup(ContractorOfferProductGroup $contractorOfferProductGroup): self
    {
        if (!$this->contractorOfferProductGroups->contains($contractorOfferProductGroup)) {
            $this->contractorOfferProductGroups[] = $contractorOfferProductGroup;
            $contractorOfferProductGroup->setProductGroup($this);
        }

        return $this;
    }

    public function removeContractorOfferProductGroup(ContractorOfferProductGroup $contractorOfferProductGroup): self
    {
        if ($this->contractorOfferProductGroups->contains($contractorOfferProductGroup)) {
            $this->contractorOfferProductGroups->removeElement($contractorOfferProductGroup);
            // set the owning side to null (unless already changed)
            if ($contractorOfferProductGroup->getProductGroup() === $this) {
                $contractorOfferProductGroup->setProductGroup(null);
            }
        }

        return $this;
    }
}
