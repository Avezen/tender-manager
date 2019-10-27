<?php
// src/AppBundle/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Auction", mappedBy="founder")
     */
    private $auctions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="user")
     */
    private $orders;

    public function __construct()
    {
        parent::__construct();
        $this->auctions = new ArrayCollection();
        $this->orders = new ArrayCollection();
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
            $auction->setFounder($this);
        }

        return $this;
    }

    public function removeAuction(Auction $auction): self
    {
        if ($this->auctions->contains($auction)) {
            $this->auctions->removeElement($auction);
            // set the owning side to null (unless already changed)
            if ($auction->getFounder() === $this) {
                $auction->setFounder(null);
            }
        }

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
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }


}