<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ProductGroupModel implements \JsonSerializable
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
     * @var $cpv
     */
    private $cpv;

    /**
     * @var $deliveryAddress
     */
    private $deliveryAddress;

    /**
     * @var $createdAt
     */
    private $createdAt;

    /**
     * @var $productGroupProducts
     */
    private $productGroupProducts;

    /**
     * @var $contractorOfferProductGroups
     */
    private $contractorOfferProductGroups;

    public function __construct(
        $id, $name, $cpv, $deliveryAddress, $createdAt, $productGroupProducts = null,
        $contractorOfferProductGroups = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpv = $cpv;
        $this->deliveryAddress = $deliveryAddress;
        $this->createdAt = $createdAt;
        $this->productGroupProducts = $productGroupProducts;
        $this->contractorOfferProductGroups = $contractorOfferProductGroups;
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

    public function getCpv() {
        return $this->cpv;
    }

    public function setCpv($cpv) {
        $this->cpv = $cpv;

        return $this;
    }

    public function getDeliveryAddress() {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress($deliveryAddress) {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProductGroupProducts() {
        return $this->productGroupProducts;
    }

    public function setProductGroupProducts($productGroupProducts) {
        $this->productGroupProducts = $productGroupProducts;

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
            'name' => $this->getName(),
            'cpv' => $this->getCpv(),
            'deliveryAddress' => $this->getDeliveryAddress(),
            'createdAt' => $this->getCreatedAt(),
            'productGroupProducts' => $this->getProductGroupProducts(),
            'contractorOfferProductGroups' => $this->getContractorOfferProductGroups()
        ];
    }
}