<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Embedded(class = "CompanyData", columnPrefix = false))
     */
    private $companyData;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Auction", mappedBy="company")
     */
    private $auctions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Request", mappedBy="company")
     */
    private $requests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="company")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="company")
     */
    private $projects;

    public function __construct()
    {
        $this->companyData = new CompanyData();
        $this->auctions = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyData(): ?CompanyData
    {
        return $this->companyData;
    }

    public function setCompanyData(CompanyData $companyData): self
    {
        $this->companyData = $companyData;

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
            $auction->setCompany($this);
        }

        return $this;
    }

    public function removeAuction(Auction $auction): self
    {
        if ($this->auctions->contains($auction)) {
            $this->auctions->removeElement($auction);
            // set the owning side to null (unless already changed)
            if ($auction->getCompany() === $this) {
                $auction->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Request[]
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setCompany($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->contains($request)) {
            $this->requests->removeElement($request);
            // set the owning side to null (unless already changed)
            if ($request->getCompany() === $this) {
                $request->setCompany(null);
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
            $order->setCompany($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getCompany() === $this) {
                $order->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setCompany($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCompany() === $this) {
                $project->setCompany(null);
            }
        }

        return $this;
    }
}

