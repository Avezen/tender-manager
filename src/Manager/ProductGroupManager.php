<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Entity\ProductGroup;
use App\Entity\ProductGroupProduct;
use App\Model\ProductColumnModel;
use App\Model\ProductGroupModel;
use App\Model\ProductGroupProductModel;
use App\RequestData\ProductGroupData;
use Doctrine\ORM\EntityManagerInterface;

class ProductGroupManager
{
    private $em;
    private $productManager;
    private $contractorOfferManager;

    public function __construct(
        EntityManagerInterface $em, ProductManager $productManager,
        ContractorOfferManager $contractorOfferManager)
    {
        $this->em = $em;
        $this->productManager = $productManager;
        $this->contractorOfferManager = $contractorOfferManager;
    }


    public function create(ProductGroupData $productGroupData)
    {
        $productGroup = new ProductGroup();

        $productGroup
            ->setName($productGroupData->name)
            ->setCpv($productGroupData->cpv)
            ->setDeliveryAddress($productGroupData->deliveryAddress)
        ;

        foreach ($productGroupData->productGroupProducts as $productGroupProductData){
            $productGroupProduct = new ProductGroupProduct();
            $productGroupProduct
                ->setProductGroup($productGroup)
                ->setProduct($productGroupProductData->product)
                ->setAmount($productGroupProductData->amount)
            ;

            $this->em->persist($productGroupProduct);
        }

        $this->em->persist($productGroup);
        $this->em->flush();

        return $productGroup;
    }

    public function update(ProductGroup $productGroup, $productGroupData)
    {
        $productGroup
            ->setName($productGroupData->name)
            ->setCpv($productGroupData->cpv)
            ->setDeliveryAddress($productGroupData->deliveryAddress)
        ;

        foreach ($productGroup->getProductGroupProducts() as $productGroupProduct){
            $this->em->remove($productGroupProduct);
        }
        $this->em->flush();

        foreach ($productGroupData->productGroupProducts as $productGroupProductData){
            $productGroupProduct = new ProductGroupProduct();
            $productGroupProduct
                ->setProductGroup($productGroup)
                ->setProduct($productGroupProductData->product)
                ->setAmount($productGroupProductData->amount)
            ;

            $this->em->persist($productGroupProduct);
        }

        $this->em->persist($productGroup);
        $this->em->flush();

        return $productGroup;
    }

    public function delete(ProductGroup $productGroup)
    {
        $this->em->remove($productGroup);
        $this->em->flush();

        return $productGroup;
    }

    public function prepareForResponse(ProductGroup $productGroup)
    {
        $productList = [];

        foreach($productGroup->getProductGroupProducts() as $product){
            $productColumns = [];
            $productProductColumns = $product->getProduct()->getProductProductColumns();

            if(!is_null($productProductColumns) && count($productProductColumns) > 0){
                foreach ($productProductColumns as $productProductColumn){
                    $productColumns[] = new ProductColumnModel(
                        $productProductColumn->getProductColumn()->getId(),
                        $productProductColumn->getProductColumn()->getName(),
                        $productProductColumn->getProductColumn()->getType(),
                        $productProductColumn->getProductColumn()->getEnabled(),
                        $productProductColumn->getValue()
                    );
                }
            }

            $productList[] = new ProductGroupProductModel(
                $product->getId(),
                $product->getProduct()->getName(),
                $product->getProduct()->getCpv(),
                $product->getProduct(),
                $product->getAmount(),
                $product->getProject() ? $product->getProject()->getName() : '',
                $productColumns
            );
        }

        return new ProductGroupModel(
            $productGroup->getId(),
            $productGroup->getName(),
            $productGroup->getCpv(),
            $productGroup->getDeliveryAddress(),
            $productGroup->getCreatedAt(),
            $productList,
            $this->contractorOfferManager->prepareProductGroupListForResponse($productGroup->getContractorOfferProductGroups()->toArray())
        );
    }

    public function prepareListForResponse(array $productGroups)
    {
        $productGroupList = [];

        foreach($productGroups as $productGroup){
            $productGroupList[] = $this->prepareForResponse($productGroup);
        }

        return $productGroupList;
    }



}