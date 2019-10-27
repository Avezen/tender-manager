<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-06-17
 * Time: 16:01
 */

namespace App\Manager;


use App\Entity\Product;
use App\Entity\ProductColumn;
use App\Entity\ProductProductColumn;
use App\Model\ProductColumnModel;
use App\Model\ProductModel;
use App\RequestData\ProductData;
use Doctrine\ORM\EntityManagerInterface;

class ProductManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function createProduct(ProductData $productData)
    {
        $product = new Product();

        $product
            ->setName($productData->name)
            ->setCpv($productData->cpv);

        foreach ($productData->productProductColumns as $productProductColumnData) {
            if ($productProductColumnData->value) {
                $productProductColumn = new ProductProductColumn();
                $productProductColumn
                    ->setProduct($product)
                    ->setProductColumn($productProductColumnData->column)
                    ->setValue($productProductColumnData->value);

                $this->em->persist($productProductColumn);
            }
        }

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function updateProduct(Product $product, ProductData $productData)
    {
        $product
            ->setName($productData->name)
            ->setCpv($productData->cpv);

        foreach ($product->getProductProductColumns() as $productProductColumn) {
            $this->em->remove($productProductColumn);
        }
        $this->em->flush();

        foreach ($productData->productProductColumns as $productProductColumnData) {
            if ($productProductColumnData->value) {
                $productProductColumn = new ProductProductColumn();

                $productProductColumn
                    ->setProduct($product)
                    ->setProductColumn($productProductColumnData->column)
                    ->setValue($productProductColumnData->value);

                $this->em->persist($productProductColumn);
            }
        }

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        if (count($product->getProductGroupProducts()) > 0) {
            return;
        }

        $this->em->remove($product);
        $this->em->flush();

        return $product;
    }

    public function prepareProductForResponse(Product $product)
    {
        $productColumns = [];
        $productProductColumns = $product->getProductProductColumns();


        if (!is_null($productProductColumns) && count($productProductColumns) > 0) {
            foreach ($productProductColumns as $productProductColumn) {
                $productColumns[] = new ProductColumnModel(
                    $productProductColumn->getProductColumn()->getId(),
                    $productProductColumn->getProductColumn()->getName(),
                    $productProductColumn->getProductColumn()->getType(),
                    $productProductColumn->getProductColumn()->getEnabled(),
                    $productProductColumn->getValue()
                );
            }
        }

        return new ProductModel(
            $product->getId(),
            $product->getName(),
            $product->getCpv(),
            $product->getCreatedAt(),
            $product->getUpdatedAt(),
            null,
            $productColumns
        );
    }

    public function prepareProductListForResponse(array $products)
    {
        $productList = [];

        foreach ($products as $product) {
            $productList[] = $this->prepareProductForResponse($product);
        }

        return $productList;
    }


    public function createColumn($productColumnData)
    {
        $productColumn = new ProductColumn();

        $productColumn
            ->setName($productColumnData->name)
            ->setType($productColumnData->type)
            ->setEnabled($productColumnData->enabled);

        $this->em->persist($productColumn);
        $this->em->flush();

        return $productColumn;
    }

    public function updateColumn(ProductColumn $productColumn, $productColumnData)
    {
        $productColumn
            ->setName($productColumnData->name)
            ->setType($productColumnData->type)
            ->setEnabled($productColumnData->enabled);

        $this->em->persist($productColumn);
        $this->em->flush();

        return $productColumn;
    }

    public function disableProductColumn(ProductColumn $productColumn)
    {
        $productColumn->setEnabled(false);

        $this->em->persist($productColumn);
        $this->em->flush();

        return $productColumn;
    }

    public function enableProductColumn(ProductColumn $productColumn)
    {
        $productColumn->setEnabled(true);

        $this->em->persist($productColumn);
        $this->em->flush();

        return $productColumn;
    }

    public function prepareProductColumnForResponse(ProductColumn $productColumn)
    {
        return new ProductColumnModel(
            $productColumn->getId(),
            $productColumn->getName(),
            $productColumn->getType(),
            $productColumn->getEnabled()
        );
    }

    public function prepareProductColumnListForResponse(array $columns)
    {
        $columnList = [];

        foreach ($columns as $column) {
            $columnList[] = $this->prepareProductColumnForResponse($column);
        }

        return $columnList;
    }
}