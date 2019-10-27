<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-01
 * Time: 14:31
 */

namespace App\Form;


use App\Entity\Company;
use App\Model\AuctionFormFields;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FormFieldTransformer implements DataTransformerInterface
{
    public function transform($formFieldsTranslated)
    {

        if ($formFieldsTranslated == null) {
            return [];
        }

        $formFields = [];

        foreach ($formFieldsTranslated as $field) {
            foreach (AuctionFormFields::FIELDS as $key => $FIELD) {
                if($field === $FIELD['field']){
                    $formFields[$key] = true;
                }
            }
        }

        return $formFields;
    }


    public function reverseTransform($formFields)
    {
        if (!$formFields) {
            return;
        }

        $auctionFormFields = [];

        foreach ($formFields as $key => $formFieldData){
            $auctionFormFields[] = AuctionFormFields::FIELDS[$key]['field'];
        }


        if (count($auctionFormFields) === 0) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'Form fields are empty'
            ));
        }
        return $auctionFormFields;

    }

}