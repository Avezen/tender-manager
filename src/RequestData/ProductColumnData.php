<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\ProductColumn;
use Symfony\Component\Validator\Constraints as Assert;

class ProductColumnData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="100")
     * @var string
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $type;

    /**
     * @Assert\NotBlank()
     * @var bool
     */
    public $enabled;

    public static function fromProductColumn(ProductColumn $productColumn): self
    {
        $productColumnData = new self();
        $productColumnData->name = $productColumn->getName();
        $productColumnData->type = $productColumn->getType();
        $productColumnData->enabled = $productColumn->getEnabled();

        return $productColumnData;
    }
}