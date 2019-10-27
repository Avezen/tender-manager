<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="float")
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductGroupProduct", mappedBy="project")
     */
    private $productGroupProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="project")
     */
    private $orderProducts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    public function __construct()
    {
        $this->productGroupProducts = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
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

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection|ProductGroupProduct[]
     */
    public function getProductGroupProducts(): Collection
    {
        return $this->productGroupProducts;
    }

    public function addProductGroupProduct(ProductGroupProduct $productGroupProduct): self
    {
        if (!$this->productGroupProducts->contains($productGroupProduct)) {
            $this->productGroupProducts[] = $productGroupProduct;
            $productGroupProduct->setProject($this);
        }

        return $this;
    }

    public function removeProductGroupProduct(ProductGroupProduct $productGroupProduct): self
    {
        if ($this->productGroupProducts->contains($productGroupProduct)) {
            $this->productGroupProducts->removeElement($productGroupProduct);
            // set the owning side to null (unless already changed)
            if ($productGroupProduct->getProject() === $this) {
                $productGroupProduct->setProject(null);
            }
        }

        return $this;
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
            $orderProduct->setProject($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProject() === $this) {
                $orderProduct->setProject(null);
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
}
