<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-02
 * Time: 09:36
 */

namespace App\RequestData;

use App\Entity\ProductColumn;
use App\Entity\ProductProductColumn;
use Symfony\Component\Validator\Constraints as Assert;

class ProductProductColumnData
{
    /**
     * @var ProductColumn
     * @Assert\NotBlank()
     */
    public $column;

    /**
     * @var string
     * @Assert\Length(min=1, max=255)
     */
    public $value;


    public static function fromProductProductColumn(ProductProductColumn $productProductColumn): self
    {
        $productProductColumnData = new self();
        $productProductColumnData->column = $productProductColumn->getProductColumn();
        $productProductColumnData->value = $productProductColumn->getValue();

        return $productProductColumnData;
    }

}