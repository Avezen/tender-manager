<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\ProductGroup;
use Symfony\Component\Validator\Constraints as Assert;

class ProductGroupData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="12")
     * @var string
     */
    public $cpv;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="255")
     * @var string
     */
    public $deliveryAddress;

    /**
     * @var array
     */
    public $request;

    /**
     * @var ProductGroupProductData[]
     * @Assert\Valid()
     */
    public $productGroupProducts;

    /**
     * @var array
     */
    public $contractorOffers;

    /**
     * @var array
     */
    public $auctions;


    public static function fromProductGroup(ProductGroup $productGroup): self
    {
        $productGroupData = new self();
        $productGroupData->name = $productGroup->getName();
        $productGroupData->cpv = $productGroup->getCpv();
        $productGroupData->deliveryAddress = $productGroup->getDeliveryAddress();

        foreach ($productGroup->getProductGroupProducts() as $productGroupProduct){
            $productGroupProductData = new ProductGroupProductData();

            $productGroupProductData->product = $productGroupProduct->getProduct();
            $productGroupProductData->amount = $productGroupProduct->getAmount();

            $productGroupData->productGroupProducts[] = $productGroupProductData;
        }

        return $productGroupData;
    }

}