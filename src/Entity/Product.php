<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="string", length=55)
     */
    private $cpv;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductGroupProduct", mappedBy="product")
     */
    private $productGroupProducts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contractor")
     */
    private $contractorProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="product")
     */
    private $orderProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductProductColumn", fetch="EAGER", mappedBy="product")
     */
    private $productProductColumns;

    public function __construct()
    {
        $this->productGroupProducts = new ArrayCollection();
        $this->contractorProducts = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
        $this->productProductColumns = new ArrayCollection();
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

    public function getCpv(): ?string
    {
        return $this->cpv;
    }

    public function setCpv(string $cpv): self
    {
        $this->cpv = $cpv;

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
            $productGroupProduct->setProduct($this);
        }

        return $this;
    }

    public function removeProductGroupProduct(ProductGroupProduct $productGroupProduct): self
    {
        if ($this->productGroupProducts->contains($productGroupProduct)) {
            $this->productGroupProducts->removeElement($productGroupProduct);
            // set the owning side to null (unless already changed)
            if ($productGroupProduct->getProduct() === $this) {
                $productGroupProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contractor[]
     */
    public function getContractorProducts(): Collection
    {
        return $this->contractorProducts;
    }

    public function addContractorProduct(Contractor $contractorProduct): self
    {
        if (!$this->contractorProducts->contains($contractorProduct)) {
            $this->contractorProducts[] = $contractorProduct;
        }

        return $this;
    }

    public function removeContractorProduct(Contractor $contractorProduct): self
    {
        if ($this->contractorProducts->contains($contractorProduct)) {
            $this->contractorProducts->removeElement($contractorProduct);
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
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductProductColumn[]
     */
    public function getProductProductColumns(): Collection
    {
        return $this->productProductColumns;
    }

    public function addProductProductColumn(ProductProductColumn $productProductColumn): self
    {
        if (!$this->productProductColumns->contains($productProductColumn)) {
            $this->productProductColumns[] = $productProductColumn;
            $productProductColumn->setProduct($this);
        }

        return $this;
    }

    public function removeProductProductColumn(ProductProductColumn $productProductColumn): self
    {
        if ($this->productProductColumns->contains($productProductColumn)) {
            $this->productProductColumns->removeElement($productProductColumn);
            // set the owning side to null (unless already changed)
            if ($productProductColumn->getProduct() === $this) {
                $productProductColumn->setProduct(null);
            }
        }

        return $this;
    }
}
