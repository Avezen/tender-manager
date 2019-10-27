<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


class ContractorOfferModel implements \JsonSerializable
{
    /**
     * @var $id
     */
    private $id;

    /**
     * @var $auction
     */
    private $auction;

    /**
     * @var $contractor
     */
    private $contractor;

    /**
     * @var $status
     */
    private $status;

    /**
     * @var $contractorOfferProductGroups
     */
    private $contractorOfferProductGroups;


    public function __construct(
        $id, $auction, $contractor, $status, $contractorOfferProductGroups = null
    )
    {
        $this->id = $id;
        $this->auction = $auction;
        $this->contractor = $contractor;
        $this->status = $status;
        $this->contractorOfferProductGroups = $contractorOfferProductGroups;
    }


    public function getId() {
        return $this->id;
    }

    public function setId() {
        $this->id;

        return $this;
    }

    public function getAuction() {
        return $this->auction;
    }

    public function setAuction($auction) {
        $this->auction = $auction;

        return $this;
    }

    public function getContractor() {
        return $this->contractor;
    }

    public function setContractor($contractor) {
        $this->contractor = $contractor;

        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    public function getContractorOfferProductGroups() {
        return $this->contractorOfferProductGroups;
    }

    public function setContractorOfferProductGroups($contractorOfferProductGroups) {
        $this->contractorOfferProductGroups = $contractorOfferProductGroups;

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
            'auction' => $this->getAuction(),
            'contractor' => $this->getContractor(),
            'status' => $this->getStatus(),
            'contractorOfferProductGroups' => $this->getContractorOfferProductGroups(),
        ];
    }
}