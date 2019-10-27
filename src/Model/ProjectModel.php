<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;



class ProjectModel implements \JsonSerializable
{
    use CreatedUpdatedTrait;

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
     * @var $company
     */
    private $budget;

    /**
     * @var $company
     */
    private $endDate;


    public function __construct(
        $id, $name, $company, $budget, $endDate, $createdAt, $updatedAt
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->company = $company;
        $this->budget = $budget;
        $this->endDate = $endDate;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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

    public function setCompany($company) {
        $this->company = $company;

        return $this;
    }

    public function getBudget() {
        return $this->budget;
    }

    public function setBudget($budget) {
        $this->budget = $budget;

        return $this;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;

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
            'company' => $this->getCompany(),
            'budget' => $this->getBudget(),
            'endDate' => $this->getEndDate(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt()
        ];
    }
}
