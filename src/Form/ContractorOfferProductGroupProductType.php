<?php

namespace App\Form;

use App\Entity\ContractorOfferProductGroup;
use App\Entity\ProductGroupProduct;
use App\RequestData\ContractorOfferProductGroupProductData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ContractorOfferProductGroupProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 1,
                    ])
                ],
                'required' => false
            ])
            ->add('productGroupProduct', EntityType::class, [
                'class' => ProductGroupProduct::class,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContractorOfferProductGroupProductData::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
