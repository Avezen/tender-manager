<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupplyRepository")
 */
class Supply
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
    private $deliveryAddress;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deliveryDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SupplyProduct", mappedBy="supply")
     */
    private $supplyProducts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="supplies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientOrder;

    public function __construct()
    {
        $this->supplyProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return Collection|SupplyProduct[]
     */
    public function getSupplyProducts(): Collection
    {
        return $this->supplyProducts;
    }

    public function addSupplyProduct(SupplyProduct $supplyProduct): self
    {
        if (!$this->supplyProducts->contains($supplyProduct)) {
            $this->supplyProducts[] = $supplyProduct;
            $supplyProduct->setSupply($this);
        }

        return $this;
    }

    public function removeSupplyProduct(SupplyProduct $supplyProduct): self
    {
        if ($this->supplyProducts->contains($supplyProduct)) {
            $this->supplyProducts->removeElement($supplyProduct);
            // set the owning side to null (unless already changed)
            if ($supplyProduct->getSupply() === $this) {
                $supplyProduct->setSupply(null);
            }
        }

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
