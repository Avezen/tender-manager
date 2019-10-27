<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


class ProductGroupProductModel implements \JsonSerializable
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
     * @var $product
     */
    private $product;

    /**
     * @var $amount
     */
    private $amount;

    /**
     * @var $project
     */
    private $project;

    /**
     * @var $productProductColumns
     */
    private $productProductColumns;

    public function __construct($id, $name, $cpv, $product, $amount, $project = null, $productProductColumns = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpv = $cpv;
        $this->product = $product;
        $this->amount = $amount;
        $this->project = $project;
        $this->productProductColumns = $productProductColumns;
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

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;

        return $this;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;

        return $this;
    }

    public function getProject() {
        return $this->project;
    }

    public function setProducts($project) {
        $this->project = $project;

        return $this;
    }

    public function getProductProductColumns() {
        return $this->productProductColumns;
    }

    public function setProductProductColumns($productProductColumns) {
        $this->productProductColumns = $productProductColumns;

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
            'product' => $this->getProduct(),
            'amount' => $this->getAmount(),
            'project' => $this->getProject(),
            'productProductColumns' => $this->getProductProductColumns()
        ];
    }
}