<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-01
 * Time: 14:31
 */

namespace App\Form;


use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IdToCompanyTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($company)
    {
        if ($company == null) {
            return 0;
        }

        return $company->getId();
    }


    public function reverseTransform($id)
    {
        if (!$id) {
            return;
        }

        $company = $this->entityManager->getRepository(Company::class)->findOneBy(
            [
                'id' => $id
            ]
        );

        if (null === $company) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A company with id "%s" does not exist!',
                $id
            ));
        }
        return $company;

    }

}