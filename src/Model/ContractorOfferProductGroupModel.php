<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


use App\Entity\ContractorOffer;
use App\Entity\ProductGroup;
use App\Service\ScoreAlgorithm;

class ContractorOfferProductGroupModel implements \JsonSerializable
{
    /**
     * @var $id
     */
    private $id;

    /**
     * @var $contractorOffer
     */
    private $contractorOffer;

    /**
     * @var $productGroup
     */
    private $productGroup;

    /**
     * @var $deliveryTime
     */
    private $deliveryTime;

    /**
     * @var $guaranteePeriod
     */
    private $guaranteePeriod;

    /**
     * @var $contractorOfferProductGroupProducts
     */
    private $contractorOfferProductGroupProducts;

    /**
     * @var $score
     */
    private $score;


    public function __construct(
        $id, $contractorOffer, $productGroup, $deliveryTime, $guaranteePeriod,
        $contractorOfferProductGroupProducts = null
    )
    {
        $this->id = $id;
        $this->contractorOffer = $contractorOffer;
        $this->productGroup = $productGroup;
        $this->deliveryTime = $deliveryTime;
        $this->guaranteePeriod = $guaranteePeriod;
        $this->contractorOfferProductGroupProducts = $contractorOfferProductGroupProducts;
        $this->score = ScoreAlgorithm::calculateTheResult(
            $this->contractorOffer, $this->contractorOfferProductGroupProducts, $this->deliveryTime, $this->guaranteePeriod
        );
    }

    public function getId() {
        return $this->id;
    }

    public function getContractorOffer() {
        return $this->contractorOffer;
    }

    public function setContractorOffer(ContractorOffer $contractorOffer) {
        $this->contractorOffer = $contractorOffer;

        return $this;
    }

    public function getProductGroup() {
        return $this->productGroup;
    }

    public function setProductGroup(ProductGroup $productGroup) {
        $this->productGroup = $productGroup;

        return $this;
    }
    public function getDeliveryTime() {
        return $this->deliveryTime;
    }

    public function setDeliveryTime($deliveryTime) {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    public function getGuaranteePeriod() {
        return $this->guaranteePeriod;
    }

    public function setGuaranteePeriod($guaranteePeriod) {
        $this->guaranteePeriod = $guaranteePeriod;

        return $this;
    }

    public function getContractorOfferProductGroupProducts() {
        return $this->contractorOfferProductGroupProducts;
    }

    public function setContractorOfferProductGroupProducts($contractorOfferProductGroupProducts) {
        $this->contractorOfferProductGroupProducts = $contractorOfferProductGroupProducts;

        return $this;
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($score) {
        $this->score = $score;

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
            'contractorOffer' => $this->getContractorOffer(),
            'productGroup' => $this->getProductGroup(),
            'deliveryTime' => $this->getDeliveryTime(),
            'guaranteePeriod' => $this->getGuaranteePeriod(),
            'contractorOfferProductGroupProducts' => $this->getContractorOfferProductGroupProducts(),
            'score' => $this->getScore(),
        ];
    }
}