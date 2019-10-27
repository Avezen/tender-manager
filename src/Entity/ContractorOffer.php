<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractorOfferRepository")
 */
class ContractorOffer
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auction", inversedBy="contractorOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auction;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Orders", mappedBy="contractorOffers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contractor", inversedBy="contractorOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contractor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractorOfferProductGroup", mappedBy="contractorOffer")
     */
    private $contractorOfferProductGroups;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->contractorOfferProductGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function setAuction(?Auction $auction): self
    {
        $this->auction = $auction;

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addContractorOffer($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removeContractorOffer($this);
        }

        return $this;
    }

    public function getContractor(): ?Contractor
    {
        return $this->contractor;
    }

    public function setContractor(?Contractor $contractor): self
    {
        $this->contractor = $contractor;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

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
            $contractorOfferProductGroup->setContractorOffer($this);
        }

        return $this;
    }

    public function removeContractorOfferProductGroup(ContractorOfferProductGroup $contractorOfferProductGroup): self
    {
        if ($this->contractorOfferProductGroups->contains($contractorOfferProductGroup)) {
            $this->contractorOfferProductGroups->removeElement($contractorOfferProductGroup);
            // set the owning side to null (unless already changed)
            if ($contractorOfferProductGroup->getContractorOffer() === $this) {
                $contractorOfferProductGroup->setContractorOffer(null);
            }
        }

        return $this;
    }
}
