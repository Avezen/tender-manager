<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="IDX_PRODUCT_COLUMN", columns={"product_id", "product_column_id"})
 * })
 * @ORM\Entity(repositoryClass="App\Repository\ProductProductColumnRepository")
 * @UniqueEntity(
 *     fields={"product","productColumn"},
 *     errorPath="productColumn",
 *     message="Product can only have one column of this type"
 * )
 */
class ProductProductColumn
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=155)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productProductColumns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductColumn", inversedBy="productProductColumns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productColumn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getProductColumn(): ?ProductColumn
    {
        return $this->productColumn;
    }

    public function setProductColumn(?ProductColumn $productColumn): self
    {
        $this->productColumn = $productColumn;

        return $this;
    }

}
