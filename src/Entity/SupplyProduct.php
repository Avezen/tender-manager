<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupplyProductRepository")
 */
class SupplyProduct
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrderProduct", inversedBy="supplyProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderProduct;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="supplyProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supply", inversedBy="supplyProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supply;

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

    public function getOrderProduct(): ?OrderProduct
    {
        return $this->orderProduct;
    }

    public function setOrderProduct(?OrderProduct $orderProduct): self
    {
        $this->orderProduct = $orderProduct;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSupply(): ?Supply
    {
        return $this->supply;
    }

    public function setSupply(?Supply $supply): self
    {
        $this->supply = $supply;

        return $this;
    }
}
