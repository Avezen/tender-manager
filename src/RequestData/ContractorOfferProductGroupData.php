<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Auction;
use App\Entity\ContractorOffer;
use App\Entity\ContractorOfferProductGroup;
use App\Entity\ContractorOfferProductGroupProduct;
use App\Entity\ProductGroup;
use Symfony\Component\Validator\Constraints as Assert;

class ContractorOfferProductGroupData
{
    /**
     * @var ContractorOffer
     */
    public $contractorOffer;

    /**
     * @var ProductGroup
     */
    public $productGroup;

    /**
     * @var ContractorOfferProductGroupProductData[]
     * @Assert\Valid()
     */
    public $contractorOfferProductGroupProducts;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Range(min=1)
     */
    public $deliveryTime;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Range(min=1)
     */
    public $guaranteePeriod;

    public static function fromContractorOfferProductGroup(ContractorOfferProductGroup $contractorOfferProductGroup): self
    {
        $contractorOfferProductGroupData = new self();

        $contractorOfferProductGroupData->contractorOffer = $contractorOfferProductGroup->getContractorOffer();
        $contractorOfferProductGroupData->productGroup = $contractorOfferProductGroup->getProductGroup();
        $contractorOfferProductGroupData->guaranteePeriod = $contractorOfferProductGroup->getGuaranteePeriod();
        $contractorOfferProductGroupData->deliveryTime = $contractorOfferProductGroup->getDeliveryTime();

        foreach ($contractorOfferProductGroup->getContractorOfferProductGroupProducts() as $contractorOfferProductGroupProduct){
            $contractorOfferProductGroupProductData = new ContractorOfferProductGroupProductData();
            $contractorOfferProductGroupProductData->productGroupProduct = $contractorOfferProductGroupProduct->getProductGroupProduct();
            $contractorOfferProductGroupProductData->contractorOfferProductGroup = $contractorOfferProductGroupProduct->getContractorOfferProductGroup();
            $contractorOfferProductGroupProductData->price = $contractorOfferProductGroupProduct->getPrice();
        }

        return $contractorOfferProductGroupData;
    }
}