<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-12
 * Time: 14:18
 */

namespace App\Model\Error;


abstract class DefaultException implements \JsonSerializable
{
    /**
     * Message
     * @var string
     * @Type("string")
     */
    protected $message;

    /**
     * Code
     * @var integer
     * @Type("integer")
     */
    protected $code;


    function __construct($message, $code) {
        $this->message = $message;
        $this->code = $code;
    }

    function getMessage() {
        return $this->message;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
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
            'message' => $this->getMessage(),
            'code' => $this->getCode()
        ];
    }
}