<?php

namespace App\Form;

use App\Entity\ProductColumn;
use App\RequestData\ProductProductColumnData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ProductProductColumnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('column', EntityType::class, [
                'class' => ProductColumn::class,
                'attr'=> [
                    'readonly' => true,
                    'style' => '-webkit-appearance: none;'
                ]
            ])
            ->add('value', TextType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductProductColumnData::class,
            'csrf_protection' => false,
        ]);
    }
}
