<?php

namespace App\Form;

use App\Entity\Auction;
use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255
                    ])
                ]
            ])
            ->add('companyNip', NumberType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255
                    ])
                ]
            ])
            ->add('companyRegon', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255
                    ])
                ]
            ])
            ->add('companyKrs', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255
                    ])
                ]
            ])
            ->add('companyAddress', TextType::class, [
            ])
            ->add('companyEmployees', NumberType::class, [
            ])
            ->add('companyCapital', NumberType::class, [
            ])
            ->add('companyYearOfOperation', TextType::class, [
            ])
            ->add('companyDescription', TextType::class, [
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ]);
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
