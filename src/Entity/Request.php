<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RequestRepository")
 */
class Request
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
     * @ORM\Column(type="array", nullable=true)
     */
    private $cpvs = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Auction", mappedBy="requests")
     */
    private $auctions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="requests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductGroup", mappedBy="request")
     */
    private $productGroups;

    public function __construct()
    {
        $this->auctions = new ArrayCollection();
        $this->productGroups = new ArrayCollection();
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

    public function getCpvs(): ?array
    {
        return $this->cpvs;
    }

    public function setCpvs(?array $cpvs): self
    {
        $this->cpvs = $cpvs;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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
            $auction->addRequest($this);
        }

        return $this;
    }

    public function removeAuction(Auction $auction): self
    {
        if ($this->auctions->contains($auction)) {
            $this->auctions->removeElement($auction);
            $auction->removeRequest($this);
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|ProductGroup[]
     */
    public function getProductGroups(): Collection
    {
        return $this->productGroups;
    }

    public function addProductGroup(ProductGroup $productGroup): self
    {
        if (!$this->productGroups->contains($productGroup)) {
            $this->productGroups[] = $productGroup;
            $productGroup->setRequest($this);
        }

        return $this;
    }

    public function removeProductGroup(ProductGroup $productGroup): self
    {
        if ($this->productGroups->contains($productGroup)) {
            $this->productGroups->removeElement($productGroup);
            // set the owning side to null (unless already changed)
            if ($productGroup->getRequest() === $this) {
                $productGroup->setRequest(null);
            }
        }

        return $this;
    }
}
