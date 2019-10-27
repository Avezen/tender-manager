<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


class ProductModel implements \JsonSerializable
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
     * @var $cpv
     */
    private $cpv;

    /**
     * @var $productGroupProduct
     */
    private $productGroupProduct;

    /**
     * @var $productProductColumns
     */
    private $productProductColumns;

    public function __construct(
        $id, $name, $cpv, $createdAt, $updatedAt,
        $productGroupProduct = null, $productProductColumns = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpv = $cpv;
        $this->productGroupProduct = $productGroupProduct;
        $this->productProductColumns = $productProductColumns;
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

    public function getCpv() {
        return $this->cpv;
    }

    public function setCpv($cpv) {
        $this->cpv = $cpv;

        return $this;
    }

    public function getProductProductColumns() {
        return $this->productProductColumns;
    }

    public function setProductProductColumns($productProductColumns) {
        $this->productProductColumns = $productProductColumns;

        return $this;
    }

    public function getProductGroupProducts() {
        return $this->productGroupProduct;
    }

    public function setProductGroupProduct($productProductColumns) {
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
            'productGroupProducts' => $this->getProductGroupProducts(),
            'productProductColumns' => $this->getProductProductColumns(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt()
        ];
    }
}