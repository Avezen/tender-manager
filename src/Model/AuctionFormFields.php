<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-12
 * Time: 12:27
 */

namespace App\Model;


use App\Entity\Auction;
use App\RequestData\ContractorOfferData;

class AuctionFormFields
{
    const FIELDS = [
        0 => [
            'field' => 'capital',
            'name' => 'Kapitał'
        ],
        1 => [
            'field' => 'employees',
            'name' => 'Liczba pracowników'
        ],
        2 => [
            'field' => 'description',
            'name' => 'Opis'
        ],
        3 => [
            'field' => 'yearOfOperation',
            'name' => 'Rok założenia działalności'
        ],
        4 => [
            'field' => 'address',
            'name' => 'Adres'
        ]
    ];

    public function validate(Auction $auction, ContractorOfferData $contractorOfferData) {
        $validated = true;
        foreach ($auction->getFormFields() as $formField) {
            if($validated) {
                foreach (self::FIELDS as $key => $FIELD) {
                    if($formField == $FIELD['field']){
                        switch ($key) {
                            case 0:
                                if(!$contractorOfferData->contractor->companyCapital){
                                    $validated = false;
                                }
                            break;
                            case 1:
                                if(!$contractorOfferData->contractor->companyEmployees){
                                    $validated = false;
                                }
                                break;
                            case 2:
                                if(!$contractorOfferData->contractor->companyDescription){
                                    $validated = false;
                                }
                                break;
                            case 3:
                                if(!$contractorOfferData->contractor->companyYearOfOperation){
                                    $validated = false;
                                }
                                break;
                            case 4:
                                if(!$contractorOfferData->contractor->companyAddress){
                                    $validated = false;
                                }
                                break;
                        }
                    }
                }
            }
        }

        return $validated;
    }
}