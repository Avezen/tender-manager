<?php

namespace App\Form;

use App\Entity\ContractorOffer;
use App\Entity\ProductGroup;
use App\RequestData\ContractorOfferProductGroupData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractorOfferProductGroupType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractorOffer', EntityType::class, [
                'class' => ContractorOffer::class,
                'required' => false
            ])
            ->add('productGroup', EntityType::class, [
                'class' => ProductGroup::class,
                'required' => false
            ])
            ->add('guaranteePeriod', NumberType::class, [
            ])
            ->add('deliveryTime', NumberType::class, [
            ])
            ->add('contractorOfferProductGroupProducts', CollectionType::class, [
                'entry_type' => ContractorOfferProductGroupProductType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => ContractorOfferProductGroupData::class,
            'allow_extra_fields' => true
        ]);
    }
}
