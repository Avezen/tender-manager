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
use App\Entity\ProductGroup;
use Symfony\Component\Validator\Constraints as Assert;

class ContractorOfferData
{
    /**
     * @var Auction
     */
    public $auction;

    /**
     * @var ProductGroup[]
     */
    public $productGroups;

    /**
     * @var ContractorData
     */
    public $contractor;

    /**
     * @var integer
     */
    public $status;

    /**
     * @var ContractorOfferProductData[]
     */
    public $contractorOfferProducts;

    public static function fromContractorOffer(ContractorOffer $contractorOffer): self
    {
        $contractorOfferData = new self();

        $contractorData = new ContractorData();
        $contractorData->name = $contractorOffer->getContractor()->getName();
        $contractorData->surname = $contractorOffer->getContractor()->getSurname();
        $contractorData->email = $contractorOffer->getContractor()->getEmail();
        $contractorData->companyName = $contractorOffer->getContractor()->getCompanyData()->getName();
        $contractorData->companyNip = $contractorOffer->getContractor()->getCompanyData()->getNip();
        $contractorData->companyRegon = $contractorOffer->getContractor()->getCompanyData()->getRegon();
        $contractorData->companyKrs = $contractorOffer->getContractor()->getCompanyData()->getKrs();
        $contractorData->companyAddress = $contractorOffer->getContractor()->getCompanyData()->getAddress();
        $contractorData->companyCapital = $contractorOffer->getContractor()->getCompanyData()->getCapital();
        $contractorData->companyEmployees = $contractorOffer->getContractor()->getCompanyData()->getEmployees();
        $contractorData->companyYearOfOperation = $contractorOffer->getContractor()->getCompanyData()->getYearOfOperation();
        $contractorData->companyDescription = $contractorOffer->getContractor()->getCompanyData()->getDescription();

        $contractorOfferData->contractor = $contractorData;


        return $contractorOfferData;
    }
}