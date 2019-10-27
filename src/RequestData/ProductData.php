<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Product;
use App\Entity\ProductProductColumn;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProductData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $cpv;

    /**
     * @var array
     */
    public $productGroupProducts;

    /**
     * @var array
     */
    public $contractorOfferProducts;

    /**
     * @var array
     */
    public $contractorProducts;

    /**
     * @var array
     */
    public $orderProducts;

    /**
     * @var ProductProductColumnData[]
     * @Assert\Valid()
     */
    public $productProductColumns;

    public static function fromProduct(Product $product): self
    {
        $productData = new self();
        $productData->name = $product->getName();
        $productData->cpv = $product->getCpv();

        foreach ($product->getProductProductColumns() as $productColumn){
            $productProductColumnData = new ProductProductColumnData();

            $productProductColumnData->column = $productColumn->getProductColumn();
            $productProductColumnData->value = $productColumn->getValue();

            $productData->productProductColumns[] = $productProductColumnData;
        }

        return $productData;
    }
}