<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Product;
use App\Entity\ProductColumn;
use App\Entity\ProductGroup;
use App\Form\ProductGroupType;
use App\Manager\ProductGroupManager;
use App\Manager\ProductManager;
use App\RequestData\ProductGroupData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Json;


class ProductGroupController extends AbstractController
{
    /**
     * @Route("/product-group/list", name="product_group_list")
     * @param ProductGroupManager $productGroupManager
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProductGroups(ProductGroupManager $productGroupManager, ProductManager $productManager)
    {
        $em = $this->getDoctrine()->getManager();

        $productGroups = $em->getRepository(ProductGroup::class)->findAll();
        $products = $em->getRepository(Product::class)->findAll();
        $productColumns = $em->getRepository(ProductColumn::class)->findAll();

        return $this->render('product-group/list.html.twig', [
            'productGroups' => $productGroupManager->prepareListForResponse($productGroups),
            'products' => $productManager->prepareProductListForResponse($products),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }

    /**
     * @Route("/product-group/{id}/view", name="product_group_view")
     * @param $id
     * @param ProductGroupManager $productGroupManager
     * @param ProductManager $productManager
     * @param ProductGroup $productGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProductGroup(
        $id, ProductGroupManager $productGroupManager, ProductManager $productManager,ProductGroup $productGroup = null
    )
    {
        if (!$productGroup) {
            return new JsonResponse(
                new EntityNotFoundMyException('Product group with id: ' . $id . ' does not exist', 404)
            );
        }
        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('product-group/view.html.twig', [
            'productGroup' => $productGroupManager->prepareForResponse($productGroup),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }

    /**
     * @Route("/product-group/create", name="product_group_create")
     * @param Request $request
     * @param ProductGroupManager $productGroupManager
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProductGroup(
        Request $request, ProductGroupManager $productGroupManager, ProductManager $productManager)
    {
        $createProductGroupData = new ProductGroupData();

        $form = $this->createForm(ProductGroupType::class, $createProductGroupData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productGroup = $productGroupManager->create($form->getData());

            $this->addFlash('success', FlashMessages::PRODUCT_GROUP_CREATE_SUCCESS);
            return $this->redirectToRoute('product_group_view', [
                'id' => $productGroup->getId(),
            ]);
        }

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('product-group/create.html.twig', [
            'form' => $form->createView(),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }

    /**
     * @Route("/product-group/{id}/edit", name="product_group_edit")
     * @param $id
     * @param Request $request
     * @param ProductGroupManager $productGroupManager
     * @param ProductManager $productManager
     * @param ProductGroup $productGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchProductGroup(
        $id, Request $request, ProductGroupManager $productGroupManager, ProductManager $productManager,
        ProductGroup $productGroup = null
    )
    {
        if (!$productGroup) {
            return new JsonResponse(
                new EntityNotFoundMyException('Product group group with id: ' . $id . ' does not exist', 404)
            );
        }
        $editProductGroupData = ProductGroupData::fromProductGroup($productGroup);

        $form = $this->createForm(ProductGroupType::class, $editProductGroupData);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $productGroup = $productGroupManager->update($productGroup, $form->getData());

            $this->addFlash('success', FlashMessages::PRODUCT_GROUP_UPDATE_SUCCESS);
            return $this->redirectToRoute('product_group_view', [
                'id' => $productGroup->getId(),
            ]);
        }

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('product-group/edit.html.twig', [
            'form' => $form->createView(),
            'productGroup' => $productGroupManager->prepareForResponse($productGroup),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }

    /**
     * @Route("/product-group/{id}/delete", name="product_group_delete")
     * @param $id
     * @param ProductGroupManager $productGroupManager
     * @param ProductGroup $productGroup
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProductGroup($id, ProductGroupManager $productGroupManager, ProductGroup $productGroup)
    {
        if (!$productGroup) {
            return new JsonResponse(
                new EntityNotFoundMyException('Product group with id: ' . $id . ' does not exist', 404)
            );
        }
        $productGroupManager->delete($productGroup);
        $this->addFlash('success', FlashMessages::PRODUCT_GROUP_DELETE_SUCCESS);

        return $this->redirectToRoute('product_group_list');
    }
}
