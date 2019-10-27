<?php

namespace App\Form;

use App\Entity\Auction;
use App\Entity\Company;
use App\RequestData\AuctionData;
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

class AuctionType extends AbstractType
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
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => function (Company $company) {
                    return sprintf('%s', $company->getCompanyData()->getName());
                },
            ])
            ->add('endDate', DateTimeType::class, array(
                'label' => 'Enable at',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
            ))
            ->add('contractorEmails', CollectionType::class, [
                'entry_type' => EmailType::class,
                'allow_add' => true,
            ])
            ->add('formFields', CollectionType::class, [
                'entry_type' => CheckboxType::class,
                'allow_add' => true,
                'required' => false,
            ])
            ->add('winnerAlgorithm', CollectionType::class, [
                'entry_type' => NumberType::class,
                'allow_add' => true,
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ]);;

        $builder->get('company')
            ->addModelTransformer(new IdToCompanyTransformer($this->em));

        $builder->get('formFields')
            ->addModelTransformer(new FormFieldTransformer());

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AuctionData::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
