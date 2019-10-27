<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


use App\Entity\Company;
use App\Entity\User;

class AuctionModel implements \JsonSerializable
{
    /**
     * @var $id
     */
    private $id;

    /**
     * @var $name
     */
    private $name;

    /**
     * @var $company
     */
    private $company;

    /**
     * @var $founder
     */
    private $founder;

    /**
     * @var $endDate
     */
    private $endDate;

    /**
     * @var $formFields
     */
    private $formFields;

    /**
     * @var $winnerAlgorithm
     */
    private $winnerAlgorithm;

    /**
     * @var $status
     */
    private $status;

    /**
     * @var $productGroups
     */
    private $productGroups;

    /**
     * @var $contractorEmails
     */
    private $contractorEmails;

    /**
     * @var $contractorOffers
     */
    private $contractorOffers;


    public function __construct(
        $id, $name, $company, $founder, $endDate, $formFields,
        $winnerAlgorithm, $status, $productGroups = null, $contractorEmails = null, $contractorOffers = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->company = $company;
        $this->founder = $founder;
        $this->endDate = $endDate;
        $this->formFields = $formFields;
        $this->winnerAlgorithm = $winnerAlgorithm;
        $this->status = $status;
        $this->productGroups = $productGroups;
        $this->contractorEmails = $contractorEmails;
        $this->contractorOffers = $contractorOffers;
    }

    public function getId() {
        return $this->id;
    }

    public function setId() {
        $this->id;

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany(Company $company) {
        $this->company = $company;

        return $this;
    }

    public function getFounder() {
        return $this->founder;
    }

    public function setFounder(User $founder) {
        $this->founder = $founder;

        return $this;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate) {
        $this->endDate = $endDate;

        return $this;
    }

    public function getFormFields() {
        return $this->formFields;
    }

    public function setFormFields($formFields) {
        $this->formFields = $formFields;

        return $this;
    }

    public function getWinnerAlgorithm() {
        return $this->winnerAlgorithm;
    }

    public function setWinnerAlgorithm($winnerAlgorithm) {
        $this->winnerAlgorithm = $winnerAlgorithm;

        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    public function getProductGroups() {
        return $this->productGroups;
    }

    public function setProductGroups($productGroups) {
        $this->productGroups = $productGroups;

        return $this;
    }

    public function getContractorEmails() {
        return $this->contractorEmails;
    }

    public function setContractorEmails($contractorEmails) {
        $this->contractorEmails = $contractorEmails;

        return $this;
    }

    public function getContractorOffers() {
        return $this->contractorOffers;
    }

    public function setContractorOffers($contractorOffers) {
        $this->contractorOffers = $contractorOffers;

        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'company' => $this->getCompany()->getCompanyData()->getName(),
            'companyName' => $this->getFounder()->getUsername(),
            'companyAddress' => $this->getEndDate(),
            'form_fields' => $this->getFormFields(),
            'winner_algorithm' => $this->getWinnerAlgorithm(),
            'status' => $this->getStatus(),
            'contractor_emails' => $this->getContractorEmails(),
            'contractor_offers' => $this->getContractorOffers(),
        ];
    }
}
