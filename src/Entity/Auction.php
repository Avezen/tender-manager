<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuctionRepository")
 */
class Auction
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
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $contractorEmails = [];

    /**
     * @ORM\Column(type="array")
     */
    private $formFields = [];

    /**
     * @ORM\Column(type="array")
     */
    private $winnerAlgorithm = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="auctions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Request", inversedBy="auctions")
     */
    private $requests;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="auctions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $founder;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractorOffer", mappedBy="auction")
     */
    private $contractorOffers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProductGroup", inversedBy="auctions")
     * @ORM\JoinColumn(nullable=true)
     */
    private $productGroups;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uuid;


    public function __construct()
    {
        $this->requests = new ArrayCollection();
        $this->contractorOffers = new ArrayCollection();
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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getContractorEmails(): ?array
    {
        return $this->contractorEmails;
    }

    public function setContractorEmails(?array $contractorEmails): self
    {
        $this->contractorEmails = $contractorEmails;

        return $this;
    }

    public function getFormFields(): ?array
    {
        return $this->formFields;
    }

    public function setFormFields(array $formFields): self
    {
        $this->formFields = $formFields;

        return $this;
    }

    public function getWinnerAlgorithm(): ?array
    {
        return $this->winnerAlgorithm;
    }

    public function setWinnerAlgorithm(array $winnerAlgorithm): self
    {
        $this->winnerAlgorithm = $winnerAlgorithm;

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
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->contains($request)) {
            $this->requests->removeElement($request);
        }

        return $this;
    }

    public function getFounder(): ?User
    {
        return $this->founder;
    }

    public function setFounder(?User $founder): self
    {
        $this->founder = $founder;

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
            $contractorOffer->setAuction($this);
        }

        return $this;
    }

    public function removeContractorOffer(ContractorOffer $contractorOffer): self
    {
        if ($this->contractorOffers->contains($contractorOffer)) {
            $this->contractorOffers->removeElement($contractorOffer);
            // set the owning side to null (unless already changed)
            if ($contractorOffer->getAuction() === $this) {
                $contractorOffer->setAuction(null);
            }
        }

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
        }

        return $this;
    }

    public function removeProductGroup(ProductGroup $productGroup): self
    {
        if ($this->productGroups->contains($productGroup)) {
            $this->productGroups->removeElement($productGroup);
        }

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
}
