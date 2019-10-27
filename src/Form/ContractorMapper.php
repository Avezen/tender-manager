<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-01
 * Time: 14:31
 */

namespace App\Form;


use App\Entity\Company;
use App\Entity\CompanyData;
use App\Entity\Contractor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ContractorMapper implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($contractor)
    {

        if ($contractor == null) {
            return 0;
        }

        return $contractor;
    }


    public function reverseTransform($contractorData)
    {
        if (!$contractorData) {
            return;
        }

        $contractor = $this->entityManager->getRepository(Contractor::class)->findOneBy(
            [
                'email' => $contractorData->email
            ]
        );


        if (null === $contractor) {
            $contractor = new Contractor();
        }

        $companyData = new CompanyData();
        $companyData
            ->setName($contractorData->companyName)
            ->setNip($contractorData->companyNip)
            ->setRegon($contractorData->companyRegon)
            ->setKrs($contractorData->companyKrs);

        $contractorData->companyAddress && $companyData->setAddress($contractorData->companyAddress);
        $contractorData->companyEmployees && $companyData->setEmployees($contractorData->companyEmployees);
        $contractorData->companyCapital && $companyData->setCapital($contractorData->companyCapital);
        $contractorData->companyYearOfOperation && $companyData->setYearOfOperation($contractorData->companyYearOfOperation);
        $contractorData->companyDescription && $companyData->setDescription($contractorData->companyDescription);

        $contractor
            ->setName($contractorData->name)
            ->setSurname($contractorData->surname)
            ->setEmail($contractorData->email)
            ->setCompanyData($companyData);

        return $contractor;

    }

}