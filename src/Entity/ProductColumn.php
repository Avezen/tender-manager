<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductColumnRepository")
 */
class ProductColumn
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductProductColumn", mappedBy="productColumn")
     */
    private $productProductColumns;

    public function __construct()
    {
        $this->productProductColumns = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

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
            $productProductColumn->setProductColumn($this);
        }

        return $this;
    }

    public function removeProductProductColumn(ProductProductColumn $productProductColumn): self
    {
        if ($this->productProductColumns->contains($productProductColumn)) {
            $this->productProductColumns->removeElement($productProductColumn);
            // set the owning side to null (unless already changed)
            if ($productProductColumn->getProductColumn() === $this) {
                $productProductColumn->setProductColumn(null);
            }
        }

        return $this;
    }
}
