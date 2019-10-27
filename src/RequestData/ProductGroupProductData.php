<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Product;
use App\Entity\ProductGroupProduct;
use Symfony\Component\Validator\Constraints as Assert;

class ProductGroupProductData
{
    /**
     * @var Product
     * @Assert\NotBlank
     */
    public $product;

    /**
     * @var integer
     * @Assert\NotBlank
     * @Assert\Range(min=1)
     */
    public $amount;


    public static function fromProductProductColumn(ProductGroupProduct $productGroupProduct): self
    {
        $productProductColumnData = new self();
        $productProductColumnData->product = $productGroupProduct->getProduct();
        $productProductColumnData->amount = $productGroupProduct->getAmount();

        return $productProductColumnData;
    }

}