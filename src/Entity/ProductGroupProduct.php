<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductGroupProductRepository")
 */
class ProductGroupProduct
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min=1)
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductGroup", inversedBy="productGroupProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productGroupProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="productGroupProducts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractorOfferProductGroupProduct", mappedBy="productGroupProduct")
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getProductGroup(): ?ProductGroup
    {
        return $this->productGroup;
    }

    public function setProductGroup(?ProductGroup $productGroup): self
    {
        $this->productGroup = $productGroup;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

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
            $contractorOfferProductGroupProduct->setProductGroupProduct($this);
        }

        return $this;
    }

    public function removeContractorOfferProductGroupProduct(ContractorOfferProductGroupProduct $contractorOfferProductGroupProduct): self
    {
        if ($this->contractorOfferProductGroupProducts->contains($contractorOfferProductGroupProduct)) {
            $this->contractorOfferProductGroupProducts->removeElement($contractorOfferProductGroupProduct);
            // set the owning side to null (unless already changed)
            if ($contractorOfferProductGroupProduct->getProductGroupProduct() === $this) {
                $contractorOfferProductGroupProduct->setProductGroupProduct(null);
            }
        }

        return $this;
    }
}
