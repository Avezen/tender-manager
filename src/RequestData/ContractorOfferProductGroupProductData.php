<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-24
 * Time: 13:11
 */

namespace App\RequestData;


use App\Entity\ContractorOfferProductGroup;
use App\Entity\ContractorOfferProductGroupProduct;
use App\Entity\ProductGroupProduct;

class ContractorOfferProductGroupProductData
{
    /**
     * @var ProductGroupProduct
     */
    public $productGroupProduct;

    /**
     * @var ContractorOfferProductGroup
     */
    public $contractorOfferProductGroup;

    /**
     * @var float
     */
    public $price;


    public static function fromContractorOfferProductGroupProduct(ContractorOfferProductGroupProduct $contractorOfferProductGroupProduct): self
    {
        $contractorOfferProductGroupProductData = new self();

        $contractorOfferProductGroupProductData->price = $contractorOfferProductGroupProduct->getPrice();
        $contractorOfferProductGroupProductData->productGroupProduct = $contractorOfferProductGroupProduct->getProductGroupProduct();
        $contractorOfferProductGroupProductData->contractorOfferProductGroup = $contractorOfferProductGroupProduct->getContractorOfferProductGroup();


        return $contractorOfferProductGroupProductData;
    }
}