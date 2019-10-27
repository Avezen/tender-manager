<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Auction;
use App\Entity\Company;
use App\Entity\ProductGroup;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class AuctionData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var \DateTime
     */
    public $endDate;

    /**
     * @var array
     */
    public $contractorEmails;

    /**
     * @var array
     */
    public $formFields;

    /**
     * @var array
     * @Assert\All(@Assert\Range(min=1, max=100))
     */
    public $winnerAlgorithm = [1, 1, 1];

    /**
     * @var integer
     */
    public $status = 10;

    /**
     * @var Company
     */
    public $company;

    /**
     * @var User
     */
    public $founder;

    /**
     * @var ProductGroupData[]
     * @Assert\Valid()
     */
    public $productGroups;

    public static function fromAuction(Auction $auction): self
    {
        $auctionData = new self();
        $auctionData->name = $auction->getName();
        $auctionData->endDate = $auction->getEndDate();
        $auctionData->contractorEmails = $auction->getContractorEmails();
        $auctionData->winnerAlgorithm = $auction->getWinnerAlgorithm();
        $auctionData->status = $auction->getStatus();
        $auctionData->company = $auction->getCompany();
        $auctionData->founder = $auction->getFounder();

        foreach ($auction->getProductGroups() as $productGroup){
            $productGroupData = new ProductGroupData();
            $productGroupData->name = $productGroup->getName();
            $productGroupData->cpv = $productGroup->getCpv();
            $productGroupData->deliveryAddress = $productGroup->getDeliveryAddress();

            foreach ($productGroup->getProductGroupProducts() as $productGroupProduct){
                $productGroupProductData = new ProductGroupProductData();

                $productGroupProductData->product = $productGroupProduct->getProduct();
                $productGroupProductData->amount = $productGroupProduct->getAmount();

                $productGroupData->productGroupProducts[] = $productGroupProductData;
            }

            $auctionData->productGroups[] = $productGroupData;
        }

        return $auctionData;
    }
}