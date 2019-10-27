<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractorOfferProductGroupProductRepository")
 * @ORM\Table(name="contractor_offer_product_group_product", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={ "product_group_product_id", "contractor_offer_product_group_id"})
 * })
 */
class ContractorOfferProductGroupProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductGroupProduct", inversedBy="contractorOfferProductGroupProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productGroupProduct;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContractorOfferProductGroup", inversedBy="contractorOfferProductGroupProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contractorOfferProductGroup;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductGroupProduct(): ?ProductGroupProduct
    {
        return $this->productGroupProduct;
    }

    public function setProductGroupProduct(?ProductGroupProduct $productGroupProduct): self
    {
        foreach ($this->contractorOfferProductGroup->getProductGroup()->getProductGroupProducts() as $productGroupProductCheck){
            if ($productGroupProductCheck === $productGroupProduct) {
                $this->productGroupProduct = $productGroupProduct;
                break;
            }
        }

        return $this;
    }

    public function getContractorOfferProductGroup(): ?ContractorOfferProductGroup
    {
        return $this->contractorOfferProductGroup;
    }

    public function setContractorOfferProductGroup(?ContractorOfferProductGroup $contractorOfferProductGroup): self
    {
        $this->contractorOfferProductGroup = $contractorOfferProductGroup;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
