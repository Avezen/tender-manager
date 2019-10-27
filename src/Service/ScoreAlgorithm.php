<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-08-06
 * Time: 13:58
 */

namespace App\Service;


use App\Entity\ContractorOffer;
use App\Entity\ContractorOfferProductGroupProduct;

class ScoreAlgorithm
{
    public static function calculateTheResult
    (
        ContractorOffer $contractorOffer, $contractorOfferProductGroupProducts, $deliveryTime, $guaranteePeriod
    ) {
        $deliveryTimeWeight = $contractorOffer->getAuction()->getWinnerAlgorithm()[0];
        $guaranteePeriodWeight = $contractorOffer->getAuction()->getWinnerAlgorithm()[0];
        $priceWeight = $contractorOffer->getAuction()->getWinnerAlgorithm()[0];

        $productsSummaryScore = 0;

        foreach ($contractorOfferProductGroupProducts->toArray() as $contractorOfferPorductGroupProduct){
            $price = $contractorOfferPorductGroupProduct->getPrice();
            $amount = $contractorOfferPorductGroupProduct->getProductGroupProduct()->getAmount();

            $productsSummaryScore = $productsSummaryScore + ($price*$amount);
        }

        $score = $productsSummaryScore*$priceWeight + $deliveryTimeWeight*$deliveryTime + $guaranteePeriodWeight*$guaranteePeriod;

        return $score;
    }
}