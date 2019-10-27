<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-11
 * Time: 13:58
 */

namespace App\Model;


class ProductColumnModel implements \JsonSerializable
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
     * @var $type
     */
    private $type;

    /**
     * @var $enabled
     */
    private $enabled;

    /**
     * @var $value
     */
    private $value;

    public function __construct($id, $name, $type, $enabled, $value = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->enabled = $enabled;
        $this->value = $value;
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

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    public function getEnabled() {
        return $this->enabled;
    }

    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;

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
        if($this->getValue()){
            return [
                'id' => $this->getId(),
                'name' => $this->getName(),
                'type' => $this->getType(),
                'enabled' => $this->getEnabled(),
                'value' => $this->getValue(),
            ];
        } else {
            return [
                'id' => $this->getId(),
                'name' => $this->getName(),
                'type' => $this->getType(),
                'enabled' => $this->getEnabled(),
            ];
        }

    }
}