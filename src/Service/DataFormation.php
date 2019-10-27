<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-25
 * Time: 09:43
 */

namespace App\Service;


use App\Entity\ContractorOffer;
use App\RequestData\ProductProductColumnData;

class DataFormation
{

    public function formOfferProductGroupData(ContractorOffer $contractorOffer) {
        $offerGroupsData = [];

        foreach ($contractorOffer->getContractorOfferProductGroups()->toArray() as $item){

            $productGroupId = $item->getProductGroup()->getId();

            $offerGroupsData[$productGroupId]['deliveryTime'] = $item->getDeliveryTime();
            $offerGroupsData[$productGroupId]['guaranteePeriod'] = $item->getGuaranteePeriod();

            foreach ($item->getContractorOfferProductGroupProducts()->toArray() as $productGroupProduct){
                $offerGroupsData[$productGroupId]['productGroupProducts'][$productGroupProduct->getProductGroupProduct()->getId()] = $productGroupProduct->getPrice();
            }
        }

        return $offerGroupsData;
    }


    public function formExistingProductColumns(array $existingProductColumns, array $currentProductProductColumns = []) {
        $productProductColumnsData = [];

        foreach ($existingProductColumns as $existingProductColumn){
            $productProductColumnData = new ProductProductColumnData();
            $productProductColumnData->column = $existingProductColumn;

            if(count($currentProductProductColumns) > 0){
                foreach ($currentProductProductColumns as $currentProductProductColumn){
                    if($currentProductProductColumn->column == $existingProductColumn){
                        $productProductColumnData->value = $currentProductProductColumn->value;
                        break;
                    }
                }
            }

            $productProductColumnsData[] = $productProductColumnData;
        }

        return $productProductColumnsData;
    }
}