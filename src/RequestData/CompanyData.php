<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Company;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyName;

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    public $companyNip;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyRegon;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyKrs;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyAddress;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $companyEmployees;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyCapital;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyYearOfOperation;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $companyDescription;

    public static function fromCompany(Company $company): self
    {
        $companyData = new self();
        $companyData->companyName = $company->getCompanyData()->getName();
        $companyData->companyNip = $company->getCompanyData()->getNip();
        $companyData->companyRegon = $company->getCompanyData()->getRegon();
        $companyData->companyKrs = $company->getCompanyData()->getKrs();
        $companyData->companyAddress = $company->getCompanyData()->getAddress();
        $companyData->companyCapital = $company->getCompanyData()->getCapital();
        $companyData->companyEmployees = $company->getCompanyData()->getEmployees();
        $companyData->companyYearOfOperation = $company->getCompanyData()->getYearOfOperation();
        $companyData->companyDescription = $company->getCompanyData()->getDescription();

        return $companyData;
    }
}