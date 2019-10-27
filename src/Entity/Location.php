<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SupplyProduct", mappedBy="location")
     */
    private $supplyProducts;

    public function __construct()
    {
        $this->supplyProducts = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $supplyProduct->setLocation($this);
        }

        return $this;
    }

    public function removeSupplyProduct(SupplyProduct $supplyProduct): self
    {
        if ($this->supplyProducts->contains($supplyProduct)) {
            $this->supplyProducts->removeElement($supplyProduct);
            // set the owning side to null (unless already changed)
            if ($supplyProduct->getLocation() === $this) {
                $supplyProduct->setLocation(null);
            }
        }

        return $this;
    }
}
