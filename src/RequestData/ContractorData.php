<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\Contractor;
use Symfony\Component\Validator\Constraints as Assert;

class ContractorData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $surname;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $email;

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
     * @var string|null
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

    public static function fromContractor(Contractor $contractor): self
    {
        $contractorData = new self();
        $contractorData->name = $contractor->getName();
        $contractorData->surname = $contractor->getSurname();
        $contractorData->email = $contractor->getEmail();
        $contractorData->companyName = $contractor->getCompanyData()->getName();
        $contractorData->companyNip = $contractor->getCompanyData()->getNip();
        $contractorData->companyRegon = $contractor->getCompanyData()->getRegon();
        $contractorData->companyKrs = $contractor->getCompanyData()->getKrs();
        $contractorData->companyAddress = $contractor->getCompanyData()->getAddress();
        $contractorData->companyCapital = $contractor->getCompanyData()->getCapital();
        $contractorData->companyEmployees = $contractor->getCompanyData()->getEmployees();
        $contractorData->companyYearOfOperation = $contractor->getCompanyData()->getYearOfOperation();
        $contractorData->companyDescription = $contractor->getCompanyData()->getDescription();

        return $contractorData;
    }
}