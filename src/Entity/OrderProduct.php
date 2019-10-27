<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderProductRepository")
 */
class OrderProduct
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="orderProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SupplyProduct", mappedBy="orderProduct")
     */
    private $supplyProduct;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="orderProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="orderProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientOrder;

    public function __construct()
    {
        $this->supplyProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    /**
     * @return Collection|SupplyProduct[]
     */
    public function getSupplyProduct(): Collection
    {
        return $this->supplyProduct;
    }

    public function addSupplyProduct(SupplyProduct $supplyProduct): self
    {
        if (!$this->supplyProduct->contains($supplyProduct)) {
            $this->supplyProduct[] = $supplyProduct;
            $supplyProduct->setOrderProduct($this);
        }

        return $this;
    }

    public function removeSupplyProduct(SupplyProduct $supplyProduct): self
    {
        if ($this->supplyProduct->contains($supplyProduct)) {
            $this->supplyProduct->removeElement($supplyProduct);
            // set the owning side to null (unless already changed)
            if ($supplyProduct->getOrderProduct() === $this) {
                $supplyProduct->setOrderProduct(null);
            }
        }

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

    public function getClientOrder(): ?Orders
    {
        return $this->clientOrder;
    }

    public function setClientOrder(?Orders $clientOrder): self
    {
        $this->clientOrder = $clientOrder;

        return $this;
    }
}
