<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Entity\Company;
use App\Entity\CompanyData;
use App\Model\CompanyModel;
use Doctrine\ORM\EntityManagerInterface;

class CompanyManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create($companyData)
    {
        $company = new Company();
        $companyD = new CompanyData();
        $companyD
            ->setName($companyData->companyName)
            ->setNip($companyData->companyNip)
            ->setRegon($companyData->companyRegon)
            ->setKrs($companyData->companyKrs)
            ->setAddress($companyData->companyAddress)
            ->setCapital($companyData->companyCapital)
            ->setEmployees($companyData->companyEmployees)
            ->setYearOfOperation($companyData->companyYearOfOperation)
            ->setDescription($companyData->companyDescription)
        ;

        $company->setCompanyData($companyD);

        $this->em->persist($company);
        $this->em->flush();

        return $company;
    }

    public function update(Company $company, $companyData)
    {
        $companyD = new CompanyData();

        $companyD
            ->setName($companyData->companyName)
            ->setNip($companyData->companyNip)
            ->setRegon($companyData->companyRegon)
            ->setKrs($companyData->companyKrs)
            ->setAddress($companyData->companyAddress)
            ->setEmployees($companyData->companyEmployees)
            ->setCapital($companyData->companyCapital)
            ->setYearOfOperation($companyData->companyYearOfOperation)
            ->setDescription($companyData->companyDescription)
        ;

        $company->setCompanyData($companyD);

        $this->em->persist($company);
        $this->em->flush();

        return $company;
    }

    public function delete(Company $company)
    {
        $this->em->remove($company);
        $this->em->flush();

        return $company;
    }

    public function prepareForResponse(Company $company)
    {
        return new CompanyModel(
            $company->getId(),
            $company->getCompanyData()->getName(),
            $company->getCompanyData()->getNip(),
            $company->getCompanyData()->getRegon(),
            $company->getCompanyData()->getKrs(),
            $company->getCompanyData()->getAddress(),
            $company->getCompanyData()->getEmployees(),
            $company->getCompanyData()->getCapital(),
            $company->getCompanyData()->getYearOfOperation(),
            $company->getCompanyData()->getDescription()
        );
    }

    public function prepareListForResponse(array $companies)
    {
        $companyList = [];

        foreach($companies as $company){
            $companyList[] = $this->prepareForResponse($company);
        }

        return $companyList;
    }



}