<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-23
 * Time: 10:20
 */

namespace App\Manager;


use App\Constants\ContractorOfferStatus;
use App\Entity\Auction;
use App\Entity\ContractorOffer;
use App\Entity\ContractorOfferProductGroup;
use App\Entity\ContractorOfferProductGroupProduct;
use App\Entity\Product;
use App\Entity\ProductGroup;
use App\Entity\ProductGroupProduct;
use App\RequestData\ContractorOfferProductGroupData;
use App\RequestData\ProductGroupData;
use Doctrine\ORM\EntityManagerInterface;

class ApiManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createProductGroup(Auction $auction, ProductGroupData $productGroupData)
    {
        $productGroup = new ProductGroup();

        $productGroup
            ->setName($productGroupData->name)
            ->setCpv($productGroupData->cpv)
            ->setDeliveryAddress($productGroupData->deliveryAddress)
            ->addAuction($auction)
        ;$this->em->persist($productGroup);

        foreach ($productGroup->getProductGroupProducts()->toArray() as $productGroupProduct) {
            $this->em->remove($productGroupProduct);
        }
        $this->em->flush();

        foreach ($productGroupData->productGroupProducts as $productGroupProductData) {

            $productGroupProduct = new ProductGroupProduct();

            $productGroupProduct
                ->setProductGroup($productGroup)
                ->setProduct($productGroupProductData->product)
                ->setAmount($productGroupProductData->amount);
            $this->em->persist($productGroupProduct);

        }
        $this->em->persist($productGroup);
        $this->em->flush();

        return $productGroup;
    }

    public function updateProductGroup(ProductGroup $productGroup, ProductGroupData $productGroupData)
    {
        $productGroup
            ->setName($productGroupData->name)
            ->setCpv($productGroupData->cpv)
            ->setDeliveryAddress($productGroupData->deliveryAddress);

        foreach ($productGroup->getProductGroupProducts()->toArray() as $productGroupProduct) {
            $this->em->remove($productGroupProduct);
        }
        $this->em->flush();

        foreach ($productGroupData->productGroupProducts as $productGroupProductData) {

            $productGroupProduct = new ProductGroupProduct();

            $productGroupProduct
                ->setProductGroup($productGroup)
                ->setProduct($productGroupProductData->product)
                ->setAmount($productGroupProductData->amount);
            $this->em->persist($productGroupProduct);

        }
        $this->em->persist($productGroup);
        $this->em->flush();

        return $productGroup;
    }


    public function removeProductGroup(ProductGroup $productGroup)
    {
        foreach ($productGroup->getProductGroupProducts()->toArray() as $productGroupProduct) {
            $this->em->remove($productGroupProduct);
        }
        $this->em->flush();

        $this->em->remove($productGroup);
        $this->em->flush();
    }

    public function createProductGroupOffer(
        ContractorOffer $contractorOffer, ContractorOfferProductGroupData $contractorOfferProductGroupData
    )
    {
        $contractorOfferProductGroup = new ContractorOfferProductGroup();
        $contractorOfferProductGroup
            ->setContractorOffer($contractorOffer)
            ->setDeliveryTime($contractorOfferProductGroupData->deliveryTime)
            ->setGuaranteePeriod($contractorOfferProductGroupData->guaranteePeriod)
            ->setProductGroup($contractorOfferProductGroupData->productGroup);

        if ($contractorOfferProductGroup->getProductGroup() === null) {
            return null;
        }

        $addedProductGroupProducts = 0;
        foreach ($contractorOfferProductGroupData->contractorOfferProductGroupProducts as $contractorOfferProductGroupProductData) {
            $contractorOfferProductGroupProduct = new ContractorOfferProductGroupProduct();
            $contractorOfferProductGroupProduct
                ->setContractorOfferProductGroup($contractorOfferProductGroup)
                ->setProductGroupProduct($contractorOfferProductGroupProductData->productGroupProduct)
                ->setPrice($contractorOfferProductGroupProductData->price);
            if ($contractorOfferProductGroupProduct->getProductGroupProduct()) {
                $this->em->persist($contractorOfferProductGroupProduct);
                $addedProductGroupProducts++;
            }
        }


        if (
            $addedProductGroupProducts ===
            count($contractorOfferProductGroupData->productGroup->getProductGroupProducts())
        ) {
            $this->em->persist($contractorOfferProductGroup);
            $this->em->flush();
        } else {
            dump('not all products from group!');
        }

        return $contractorOfferProductGroup;
    }

    public function updateProductGroupOffer(
        ContractorOfferProductGroup $contractorOfferProductGroup,
        ContractorOfferProductGroupData $contractorOfferProductGroupData
    )
    {
        $contractorOfferProductGroup
            ->setDeliveryTime($contractorOfferProductGroupData->deliveryTime)
            ->setGuaranteePeriod($contractorOfferProductGroupData->guaranteePeriod)
            ->setProductGroup($contractorOfferProductGroupData->productGroup);

        if ($contractorOfferProductGroup->getProductGroup() === null) {
            return null;
        }

        foreach ($contractorOfferProductGroup->getContractorOfferProductGroupProducts()->toArray() as $contractorOfferProductGroupProduct){
            $this->em->remove($contractorOfferProductGroupProduct);
        }
        $this->em->flush();

        $addedProductGroupProducts = 0;
        foreach ($contractorOfferProductGroupData->contractorOfferProductGroupProducts as $contractorOfferProductGroupProductData) {
            $contractorOfferProductGroupProduct = new ContractorOfferProductGroupProduct();
            $contractorOfferProductGroupProduct
                ->setContractorOfferProductGroup($contractorOfferProductGroup)
                ->setProductGroupProduct($contractorOfferProductGroupProductData->productGroupProduct)
                ->setPrice($contractorOfferProductGroupProductData->price);
            if ($contractorOfferProductGroupProduct->getProductGroupProduct()) {
                $this->em->persist($contractorOfferProductGroupProduct);
                $addedProductGroupProducts++;
            }
        }

        if (
            $addedProductGroupProducts ===
            count($contractorOfferProductGroupData->productGroup->getProductGroupProducts())
        ) {
            $this->em->persist($contractorOfferProductGroup);
            $this->em->flush();
        } else {
            dump('not all products from group!');
        }

        return $contractorOfferProductGroup;
    }

    public function setContractorOfferStatusToSent(ContractorOffer $contractorOffer) {
        $contractorOffer->setStatus(ContractorOfferStatus::SENT);

        $this->em->persist($contractorOffer);
        $this->em->flush();

        return $contractorOffer;
    }


}