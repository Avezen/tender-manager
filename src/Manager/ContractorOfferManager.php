<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Constants\AuctionStatus;
use App\Entity\Auction;
use App\Entity\Company;
use App\Entity\CompanyData;
use App\Entity\Contractor;
use App\Entity\ContractorOffer;
use App\Entity\ContractorOfferProductGroup;
use App\Entity\ProductGroup;
use App\Entity\ProductGroupProduct;
use App\Model\AuctionFormFields;
use App\Model\AuctionModel;
use App\Model\ContractorOfferModel;
use App\Model\ContractorOfferProductGroupModel;
use App\RequestData\AuctionData;
use App\RequestData\ContractorOfferData;
use App\Util\UUIDGenerator;
use Doctrine\ORM\EntityManagerInterface;

class ContractorOfferManager
{
    private $em;
    private $uuidGenerator;

    public function __construct(EntityManagerInterface $em, UuidGenerator $uuidGenerator)
    {
        $this->em = $em;
        $this->uuidGenerator = $uuidGenerator;
    }


    public function create(Auction $auction, ContractorOfferData $contractorOfferData)
    {
        $contractorOffer = new ContractorOffer();

        $contractor = new Contractor();

        if(!(new AuctionFormFields)->validate($auction, $contractorOfferData)){
            return null;
        }

        $companyData = new CompanyData();
        $companyData
            ->setName($contractorOfferData->contractor->companyName)
            ->setNip($contractorOfferData->contractor->companyNip)
            ->setKrs($contractorOfferData->contractor->companyKrs)
            ->setRegon($contractorOfferData->contractor->companyRegon)
            ->setCapital($contractorOfferData->contractor->companyCapital)
            ->setAddress($contractorOfferData->contractor->companyAddress)
            ->setYearOfOperation($contractorOfferData->contractor->companyYearOfOperation)
            ->setDescription($contractorOfferData->contractor->companyDescription)
            ->setEmployees($contractorOfferData->contractor->companyEmployees)
        ;

        $contractor
            ->setName($contractorOfferData->contractor->name)
            ->setSurname($contractorOfferData->contractor->surname)
            ->setEmail($contractorOfferData->contractor->email)
            ->setCompanyData($companyData);
        ;
        $this->em->persist($contractor);

        $contractorOffer
            ->setAuction($auction)
            ->setStatus(10)
            ->setContractor($contractor)
            ->setUuid($this->uuidGenerator->generateUUID(ContractorOffer::class))
        ;


        $this->em->persist($contractorOffer);
        $this->em->flush();

        return $contractorOffer;
    }

    public function update(ContractorOffer $contractorOffer, ContractorOfferData $contractorOfferData)
    {
        $contractor = $contractorOffer->getContractor();

        if(!(new AuctionFormFields)->validate($contractorOffer->getAuction(), $contractorOfferData)){
            return null;
        }

        $companyData = new CompanyData();
        $companyData
            ->setName($contractorOfferData->contractor->companyName)
            ->setNip($contractorOfferData->contractor->companyNip)
            ->setKrs($contractorOfferData->contractor->companyKrs)
            ->setRegon($contractorOfferData->contractor->companyRegon)
            ->setCapital($contractorOfferData->contractor->companyCapital)
            ->setAddress($contractorOfferData->contractor->companyAddress)
            ->setYearOfOperation($contractorOfferData->contractor->companyYearOfOperation)
            ->setDescription($contractorOfferData->contractor->companyDescription)
            ->setEmployees($contractorOfferData->contractor->companyEmployees)
        ;

        $contractor
            ->setName($contractorOfferData->contractor->name)
            ->setSurname($contractorOfferData->contractor->surname)
            ->setEmail($contractorOfferData->contractor->email)
            ->setCompanyData($companyData);
        ;
        $this->em->persist($contractor);


        $this->em->persist($contractor);
        $this->em->flush();

        return $contractorOffer;
    }

    public function delete(ContractorOffer $contractorOffer)
    {
        $this->em->remove($contractorOffer);
        $this->em->flush();

        return $contractorOffer;
    }

    public function prepareForResponse(ContractorOffer $contractorOffer)
    {
        return new ContractorOfferModel(
            $contractorOffer->getId(),
            $contractorOffer->getAuction(),
            $contractorOffer->getContractor(),
            $contractorOffer->getStatus(),
            $this->prepareProductGroupListForResponse($contractorOffer->getContractorOfferProductGroups()->toArray())
        );
    }

    public function prepareListForResponse(array $auctions)
    {
        $auctionList = [];

        foreach ($auctions as $auction) {
            $auctionList[] = $this->prepareForResponse($auction);
        }

        return $auctionList;
    }

    public function prepareProductGroupForResponse(ContractorOfferProductGroup $contractorOfferProductGroup)
    {
        return new ContractorOfferProductGroupModel(
            $contractorOfferProductGroup->getId(),
            $contractorOfferProductGroup->getContractorOffer(),
            $contractorOfferProductGroup->getProductGroup(),
            $contractorOfferProductGroup->getDeliveryTime(),
            $contractorOfferProductGroup->getGuaranteePeriod(),
            $contractorOfferProductGroup->getContractorOfferProductGroupProducts()
        );
    }

    public function prepareProductGroupListForResponse(array $contractorOfferProductGroups)
    {
        $contractorOfferProductGroupList = [];

        foreach ($contractorOfferProductGroups as $contractorOfferProductGroup) {
            $contractorOfferProductGroupList[] = $this->prepareProductGroupForResponse($contractorOfferProductGroup);
        }

        return $contractorOfferProductGroupList;
    }

}