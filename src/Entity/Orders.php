<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="clientOrder")
     */
    private $orderProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Supply", mappedBy="clientOrder")
     */
    private $supplies;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ContractorOffer", inversedBy="orders")
     */
    private $contractorOffers;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
        $this->supplies = new ArrayCollection();
        $this->contractorOffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setClientOrder($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getClientOrder() === $this) {
                $orderProduct->setClientOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Supply[]
     */
    public function getSupplies(): Collection
    {
        return $this->supplies;
    }

    public function addSupply(Supply $supply): self
    {
        if (!$this->supplies->contains($supply)) {
            $this->supplies[] = $supply;
            $supply->setClientOrder($this);
        }

        return $this;
    }

    public function removeSupply(Supply $supply): self
    {
        if ($this->supplies->contains($supply)) {
            $this->supplies->removeElement($supply);
            // set the owning side to null (unless already changed)
            if ($supply->getClientOrder() === $this) {
                $supply->setClientOrder(null);
            }
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ContractorOffer[]
     */
    public function getContractorOffers(): Collection
    {
        return $this->contractorOffers;
    }

    public function addContractorOffer(ContractorOffer $contractorOffer): self
    {
        if (!$this->contractorOffers->contains($contractorOffer)) {
            $this->contractorOffers[] = $contractorOffer;
        }

        return $this;
    }

    public function removeContractorOffer(ContractorOffer $contractorOffer): self
    {
        if ($this->contractorOffers->contains($contractorOffer)) {
            $this->contractorOffers->removeElement($contractorOffer);
        }

        return $this;
    }
}
