<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Entity\CompanyData;
use App\Entity\Contractor;
use App\Model\ContractorModel;
use App\RequestData\ContractorData;
use Doctrine\ORM\EntityManagerInterface;

class ContractorManager
{
    private $em;
    private $contractorOfferManager;

    public function __construct(EntityManagerInterface $em, ContractorOfferManager $contractorOfferManager)
    {
        $this->em = $em;
        $this->contractorOfferManager = $contractorOfferManager;
    }

    public function create(ContractorData $contractorData)
    {
        $contractor = new Contractor();
        $companyData = new CompanyData();

        $companyData
            ->setName($contractorData->companyName)
            ->setNip($contractorData->companyNip)
            ->setRegon($contractorData->companyRegon)
            ->setKrs($contractorData->companyKrs)
            ->setAddress($contractorData->companyAddress)
            ->setEmployees($contractorData->companyEmployees)
            ->setCapital($contractorData->companyCapital)
            ->setYearOfOperation($contractorData->companyYearOfOperation)
            ->setDescription($contractorData->companyDescription)
        ;

        $contractor
            ->setName($contractorData->name)
            ->setSurname($contractorData->surname)
            ->setEmail($contractorData->email)
            ->setCompanyData($companyData)
        ;

        $this->em->persist($contractor);
        $this->em->flush();

        return $contractor;
    }

    public function update(Contractor $contractor, ContractorData $contractorData)
    {
        $companyData = new CompanyData();

        $companyData
            ->setName($contractorData->companyName)
            ->setNip($contractorData->companyNip)
            ->setRegon($contractorData->companyRegon)
            ->setKrs($contractorData->companyKrs)
            ->setAddress($contractorData->companyAddress)
            ->setEmployees($contractorData->companyEmployees)
            ->setCapital($contractorData->companyCapital)
            ->setYearOfOperation($contractorData->companyYearOfOperation)
            ->setDescription($contractorData->companyDescription)
        ;

        $contractor
            ->setName($contractorData->name)
            ->setSurname($contractorData->surname)
            ->setCompanyData($companyData)
        ;

        $this->em->persist($contractor);
        $this->em->flush();

        return $contractor;
    }

    public function delete(Contractor $contractor)
    {
        $this->em->remove($contractor);
        $this->em->flush();

        return $contractor;
    }

    public function prepareForResponse(Contractor $contractor)
    {
        return new ContractorModel(
            $contractor->getId(),
            $contractor->getName(),
            $contractor->getSurname(),
            $contractor->getEmail(),
            $contractor->getCompanyData()->getName(),
            $contractor->getCompanyData()->getNip(),
            $contractor->getCompanyData()->getRegon(),
            $contractor->getCompanyData()->getKrs(),
            $contractor->getCompanyData()->getAddress(),
            $contractor->getCompanyData()->getEmployees(),
            $contractor->getCompanyData()->getCapital(),
            $contractor->getCompanyData()->getYearOfOperation(),
            $contractor->getCompanyData()->getDescription(),
            $this->contractorOfferManager->prepareListForResponse($contractor->getContractorOffers()->toArray())
        );
    }

    public function prepareListForResponse(array $contractors)
    {
        $contractorList = [];

        foreach($contractors as $contractor){
            $contractorList[] = $this->prepareForResponse($contractor);
        }

        return $contractorList;
    }



}