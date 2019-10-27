<?php

namespace App\Form;

use App\RequestData\ProductGroupData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProductGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
            ])
            ->add('cpv', TextType::class, [
            ])
            ->add('deliveryAddress', TextType::class, [
            ])
            ->add('productGroupProducts', CollectionType::class, [
                'entry_type' => ProductGroupProductType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductGroupData::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
