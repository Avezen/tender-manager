<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-04
 * Time: 14:04
 */

namespace App\Model;


trait CreatedUpdatedTrait
{
    /**
     * @var $createdAt
     */
    private $createdAt;

    /**
     * @var $createdAt
     */
    private $updatedAt;

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}