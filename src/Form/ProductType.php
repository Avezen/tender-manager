<?php

namespace App\Form;

use App\RequestData\ProductData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProductType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
            ])
            ->add('cpv', TextType::class, [
            ])
            ->add('productProductColumns', CollectionType::class, [
                'entry_type' => ProductProductColumnType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductData::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
