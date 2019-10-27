<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Product;
use App\Entity\ProductColumn;
use App\Entity\ProductProductColumn;
use App\Form\ProductColumnType;
use App\Form\ProductType;
use App\Manager\ProductManager;
use App\Model\Error\EntityNotFoundException;
use App\RequestData\ProductColumnData;
use App\RequestData\ProductData;
use App\RequestData\ProductProductColumnData;
use App\Service\DataFormation;
use Hisune\EchartsPHP\Doc\IDE\Aria\Data;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Json;


class ProductController extends AbstractController
{
    /**
     * @Route("/product/list", name="product_list")
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProducts(ProductManager $productManager)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();

//        $this->denyAccessUnlessGranted(AccountVoter::HAS_ACCOUNT, $account);
//        $this->denyAccessUnlessGranted(ProductVoter::VIEW, $product);
        return $this->render('product/list.html.twig', [
            'products' => $productManager->prepareProductListForResponse($products),
        ]);
    }


    /**
     * @Route("/product/{id}/view", name="product_view")
     * @param $id
     * @param ProductManager $productManager
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProduct($id, ProductManager $productManager, Product $product = null)
    {
        if(!$product){
            return new JsonResponse(
                new EntityNotFoundException('Product with id: ' . $id . ' does not exist', 404)
            );
        }

        return $this->render('product/view.html.twig', [
            'product' => $productManager->prepareProductForResponse($product),
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     * @param Request $request
     * @param ProductManager $productManager
     * @param DataFormation $dataFormation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createProduct(Request $request, ProductManager $productManager, DataFormation $dataFormation)
    {
        $createProductData = new ProductData();

        $existingProductColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();
        $productProductColumnsData = $dataFormation->formExistingProductColumns($existingProductColumns);
        $createProductData->productProductColumns = $productProductColumnsData;

        $form = $this->createForm(ProductType::class, $createProductData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $productManager->createProduct($form->getData());

            $this->addFlash('success', FlashMessages::PRODUCT_CREATE_SUCCESS);
            return $this->redirectToRoute('product_view', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}/edit", name="product_edit")
     * @param $id
     * @param Request $request
     * @param ProductManager $productManager
     * @param Product $product
     * @param DataFormation $dataFormation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editProduct(
        $id, Request $request, ProductManager $productManager, Product $product = null, DataFormation $dataFormation
    )
    {
        if(!$product){
            return new JsonResponse(
                new EntityNotFoundException('Product with id: ' . $id . ' does not exist', 404)
            );
        }

        $editProductData = ProductData::fromProduct($product);

        $existingProductColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();
        $productProductColumnsData = $dataFormation->formExistingProductColumns($existingProductColumns, $editProductData->productProductColumns);
        $editProductData->productProductColumns = $productProductColumnsData;

        $form = $this->createForm(ProductType::class, $editProductData);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $product = $productManager->updateProduct($product, $form->getData());

            $this->addFlash('success', FlashMessages::PRODUCT_UPDATE_SUCCESS);
            return $this->redirectToRoute('product_view', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route("/product/{id}/delete", name="product_delete")
     * @param $id
     * @param ProductManager $productManager
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteProduct($id, ProductManager $productManager, Product $product = null)
    {
        if(!$product){
            return new JsonResponse(
                new EntityNotFoundException('Product with id: ' . $id . ' does not exist', 404)
            );
        }
        $productManager->deleteProduct($product);
        $this->addFlash('success', FlashMessages::PRODUCT_DELETE_SUCCESS);

        return $this->redirectToRoute('product_group_list');
    }


    /**
     * @Route("/product-column/list", name="product_column_list")
     * @param ProductManager $productManager
     * @return JsonResponse
     */
    public function getProductColumns(ProductManager $productManager)
    {
        //$this->denyAccessUnlessGranted(AccountVoter::HAS_ACCOUNT, $account);
        //$this->denyAccessUnlessGranted(ProductVoter::VIEW, $product);
        $em = $this->getDoctrine()->getManager();

        $productColumns = $em->getRepository(ProductColumn::class)->findAll();

        return new JsonResponse($productManager->prepareProductColumnListForResponse($productColumns));
    }

    /**
     * @Route("/product-column/{id}", name="product_column_view")
     * @param $id
     * @param ProductManager $productManager
     * @param ProductColumn $productColumn
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOneProductColumn($id, ProductManager $productManager, ProductColumn $productColumn = null)
    {
        if(!$productColumn){
            return new JsonResponse(
                new EntityNotFoundException('Product column with id: ' . $id . ' does not exist', 404)
            );
        }

        return $this->render('product-column/view.html.twig', [
            'column' => $productManager->prepareProductColumnForResponse($productColumn),
        ]);
    }

    /**
     * @Route("/product-column", name="product_column_create")
     * @param Request $request
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProductColumn(Request $request, ProductManager $productManager)
    {
        $createProductColumnData = new ProductColumnData();

        $form = $this->createForm(ProductColumnType::class, $createProductColumnData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productColumn = $productManager->createColumn($form->getData());

            $this->addFlash('success', FlashMessages::PRODUCT_COLUMN_CREATE_SUCCESS);
            return $this->redirectToRoute('product_column_view', [
                'id' => $productColumn->getId()
            ]);
        }

        return $this->render('product-column/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product-column/{id}/edit", name="product_column_edit")
     * @param $id
     * @param Request $request
     * @param ProductManager $productManager
     * @param ProductColumn $productColumn
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editProductColumn(
        $id, Request $request, ProductManager $productManager, ProductColumn $productColumn = null
    )
    {
        if(!$productColumn){
            return new JsonResponse(
                new EntityNotFoundException('Product column with id: ' . $id . ' does not exist', 404)
            );
        }

        $editProductColumnData = ProductColumnData::fromProductColumn($productColumn);

        $form = $this->createForm(ProductColumnType::class, $editProductColumnData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productColumn = $productManager->updateColumn($productColumn, $form->getData());

            $this->addFlash('success', FlashMessages::PRODUCT_COLUMN_UPDATE_SUCCESS);
            return $this->redirectToRoute('product_column_view', [
                'id' => $productColumn->getId()
            ]);
        }

        return $this->render('product-column/edit.html.twig', [
            'form' => $form->createView(),
            'column' => $productColumn
        ]);
    }

    /**
     * @Route("/product-column/{id}/disable", name="product_column_disable", methods={"PATCH"})
     * @param ProductColumn $productColumn
     * @param ProductManager $productManager
     * @return \Symfony\Component\Form\FormInterface|JsonResponse
     */
    public function disableColumn(ProductColumn $productColumn, ProductManager $productManager)
    {
        $productColumn = $productManager->disableProductColumn($productColumn);

        return new JsonResponse($productManager->prepareProductColumnForResponse($productColumn));
    }

    /**
     * @Route("/product-column/{id}/enable", name="product_column_enable", methods={"PATCH"})
     * @param $id
     * @param ProductManager $productManager
     * @param ProductColumn $productColumn
     * @return \Symfony\Component\Form\FormInterface|JsonResponse
     */
    public function enableColumn($id, ProductManager $productManager, ProductColumn $productColumn)
    {
        if(!$productColumn){
            return new JsonResponse(
                new EntityNotFoundException('Product column with id: ' . $id . ' does not exist', 404)
            );
        }

        $productColumn = $productManager->enableProductColumn($productColumn);

        return new JsonResponse($productManager->prepareProductColumnForResponse($productColumn));
    }
}
