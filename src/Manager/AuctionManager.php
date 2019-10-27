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
use App\Entity\ProductGroup;
use App\Entity\ProductGroupProduct;
use App\Entity\User;
use App\Model\AuctionFormFields;
use App\Model\AuctionModel;
use App\RequestData\AuctionData;
use App\Util\UUIDGenerator;
use Doctrine\ORM\EntityManagerInterface;

class AuctionManager
{
    private $em;
    private $uuidGenerator;
    private $contractorOfferManager;
    private $productGroupManager;

    public function __construct(
        EntityManagerInterface $em, UuidGenerator $uuidGenerator, ContractorOfferManager $contractorOfferManager,
        ProductGroupManager $productGroupManager
    )
    {
        $this->em = $em;
        $this->uuidGenerator = $uuidGenerator;
        $this->contractorOfferManager = $contractorOfferManager;
        $this->productGroupManager = $productGroupManager;
    }


    public function create(AuctionData $auctionData)
    {
        $auction = new Auction();

        $auction
            ->setName($auctionData->name)
            ->setStatus($auctionData->status)
            ->setEndDate($auctionData->endDate)
            ->setFormFields($auctionData->formFields)
            ->setContractorEmails($auctionData->contractorEmails)
            ->setWinnerAlgorithm($auctionData->winnerAlgorithm)
            ->setFounder($this->em->getRepository(User::class)->find(1)) // ToDo: current user
            ->setCompany($auctionData->company)
        ;

        $this->em->persist($auction);
        $this->em->flush();

        return $auction;
    }

    public function update(Auction $auction, AuctionData $auctionData)
    {
        $auction
            ->setName($auctionData->name)
            ->setStatus($auctionData->status)
            ->setEndDate($auctionData->endDate)
            ->setFormFields($auctionData->formFields)
            ->setContractorEmails($auctionData->contractorEmails)
            ->setWinnerAlgorithm($auctionData->winnerAlgorithm)
            ->setFounder($auctionData->founder)
            ->setCompany($auctionData->company)
        ;


        foreach ($auction->getProductGroups() as $productGroup){
            foreach ($productGroup->getProductGroupProducts() as $productGroupProduct){
                $this->em->remove($productGroupProduct);
            }
            $this->em->remove($productGroup);
        }

        if($auctionData->productGroups)
        foreach ($auctionData->productGroups as $productGroupData){
            $productGroup = new ProductGroup();

            $productGroup
                ->setName($productGroupData->name)
                ->setCpv($productGroupData->cpv)
                ->setDeliveryAddress($productGroupData->deliveryAddress)
            ;
            $auction->addProductGroup($productGroup);
            $this->em->persist($productGroup);

            foreach ($productGroupData->productGroupProducts as $productGroupProductData){
                $productGroupProduct = new ProductGroupProduct();
                $productGroupProduct
                    ->setProductGroup($productGroup)
                    ->setProduct($productGroupProductData->product)
                    ->setAmount($productGroupProductData->amount)
                ;
                $this->em->persist($productGroupProduct);
            }
        }

        $this->em->persist($auction);
        $this->em->flush();

        return $auction;
    }

    public function start(Auction $auction)
    {
        if(count($auction->getProductGroups()->toArray()) > 0){
            $auction
                ->setStatus(AuctionStatus::IN_PROGRESS)
                ->setUuid($this->uuidGenerator->generateUUID(Auction::class))
            ;

            $this->em->persist($auction);
            $this->em->flush();

            return true;
        }

        return false;
    }

    public function delete(Auction $auction)
    {
        $this->em->remove($auction);
        $this->em->flush();

        return $auction;
    }

    public function updateFinishedAuctionsStatus(array $auctions)
    {

        foreach ($auctions as $auction){
            if($auction->getEndDate() < (new \DateTime('now')) ){
                if(count($auction->getContractorOffers()->toArray()) > 0){
                    $auction->setStatus(AuctionStatus::FINISHED);
                }else{
                    $auction->setStatus(AuctionStatus::FINISHED_EMPTY);
                }

                $this->em->persist($auction);
                $this->em->flush();
            }
        }
    }

    public function prepareForResponse(Auction $auction)
    {
        return new AuctionModel(
            $auction->getId(),
            $auction->getName(),
            $auction->getCompany(),
            $auction->getFounder(),
            $auction->getEndDate(),
            $auction->getFormFields(),
            $auction->getWinnerAlgorithm(),
            $auction->getStatus(),
            $auction->getProductGroups() ? $this->productGroupManager->prepareListForResponse($auction->getProductGroups()->toArray()) : [],
            $auction->getContractorEmails(),
            $auction->getContractorOffers() ? $this->contractorOfferManager->prepareListForResponse($auction->getContractorOffers()->toArray()) : []
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


}