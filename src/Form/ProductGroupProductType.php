<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductColumn;
use App\Entity\ProductProductColumn;
use App\RequestData\ProductGroupProductData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ProductGroupProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => function(Product $product) {
                    return sprintf('%s', $product->getName());
                },
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('amount', NumberType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductGroupProductData::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
