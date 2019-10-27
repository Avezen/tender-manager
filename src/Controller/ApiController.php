<?php

namespace App\Controller;

use App\Entity\Auction;
use App\Entity\ContractorOffer;
use App\Entity\ContractorOfferProductGroupProduct;
use App\Entity\Product;
use App\Entity\ProductColumn;
use App\Entity\ProductGroup;
use App\Form\ContractorOfferProductGroupType;
use App\Form\ProductGroupType;
use App\Manager\ApiManager;
use App\Manager\ContractorOfferManager;
use App\Manager\ProductGroupManager;
use App\Manager\ProductManager;
use App\Model\AuctionFormFields;
use App\RequestData\ContractorOfferProductGroupData;
use App\RequestData\ProductGroupData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;


/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/product/list", name="api_products_columns")
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProducts(ProductManager $productManager)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();
        $productColumns = $em->getRepository(ProductColumn::class)->findAll();

        return new JsonResponse(
            [
                'products' => $productManager->prepareProductListForResponse($products),
                'productColumns' => $productManager->prepareProductColumnListForResponse($productColumns)
            ]
        );
    }

    /**
     * @Route("/product-group/{id}/product/list", name="api_products_groupProducts_columns")
     * @param $id
     * @param ProductManager $productManager
     * @param ProductGroupManager $productGroupManager
     * @param ProductGroup $productGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProductGroupProducts(
        $id, ProductManager $productManager, ProductGroupManager $productGroupManager,
        ProductGroup $productGroup = null
    )
    {
        if(!$productGroup){
            return new JsonResponse(
                new EntityNotFoundMyException('Product group with id: ' . $id . ' does not exist', 404)
            );
        }

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();
        $productColumns = $em->getRepository(ProductColumn::class)->findAll();

        return new JsonResponse(
            [
                'products' => $productManager->prepareProductListForResponse($products),
                'productColumns' => $productManager->prepareProductColumnListForResponse($productColumns),
                'productGroupProducts' => $productGroupManager->prepareForResponse($productGroup)
            ]
        );
    }

    /**
     * @Route("/product/{id}/column/list", name="api_product_column_list")
     * @param $id
     * @param ProductManager $productManager
     * @param Product|null $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProductColumnList(
        $id, ProductManager $productManager, Product $product = null
    )
    {
        if(!$product){
            return new JsonResponse(
                new EntityNotFoundMyException('Product with id: ' . $id . ' does not exist', 404)
            );
        }
        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return new JsonResponse(
            [
                'product' => $productManager->prepareProductForResponse($product),
                'productColumns' => $productManager->prepareProductColumnListForResponse($productColumns)
            ]
        );
    }

    /**
     * @Route("/auction/{id}/form/checkbox", name="api_auction_form_checkbox")
     * @param $id
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFormCheckbox($id, Auction $auction = null)
    {
        if($auction === null){
            return new JsonResponse(AuctionFormFields::FIELDS);
        }else {
            return new JsonResponse([
                'fields' => AuctionFormFields::FIELDS,
                'auctionFields' => $auction->getFormFields()
            ]);
        }

    }

    /**
     * @Route("/auction/{id}/product-group/create", name="api_create_product_group")
     * @param Request $request
     * @param ApiManager $apiManager
     * @param ProductGroupManager $productGroupManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postNewProductGroup(
        Request $request, ApiManager $apiManager, ProductGroupManager $productGroupManager,
        Auction $auction = null
    )
    {
        $data = json_decode($request->getContent(), true);

        $createProductGroupData = new ProductGroupData();

        $form = $this->createForm(ProductGroupType::class, $createProductGroupData);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $productGroup = $apiManager->createProductGroup($auction, $form->getData());
            $response = $productGroupManager->prepareForResponse($productGroup);
        }else{
            $response = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $this->getErrorsFromForm($form)
            ];
            return new JsonResponse($response, 400);
        }

        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/product-group/{id}/edit", name="api_edit_product_group")
     * @param Request $request
     * @param ApiManager $apiManager
     * @param ProductGroupManager $productGroupManager
     * @param ProductGroup|null $productGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEditProductGroup(
        Request $request, ApiManager $apiManager, ProductGroupManager $productGroupManager,
        ProductGroup $productGroup = null
    )
    {
        $data = json_decode($request->getContent(), true);

        $editProductGroupData = new ProductGroupData();

        $form = $this->createForm(ProductGroupType::class, $editProductGroupData);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $productGroup = $apiManager->updateProductGroup($productGroup, $form->getData());
            $response = $productGroupManager->prepareForResponse($productGroup);
        }else{
            $response = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $this->getErrorsFromForm($form)
            ];
            return new JsonResponse($response, 400);
        }

        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/product-group/{id}/remove", name="api_remove_product_group")
     * @param ApiManager $apiManager
     * @param ProductGroupManager $productGroupManager
     * @param ProductGroup|null $productGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRemoveProductGroup(
        ApiManager $apiManager, ProductGroupManager $productGroupManager,
        ProductGroup $productGroup = null
    )
    {
        $apiManager->removeProductGroup($productGroup);

        return new JsonResponse($productGroupManager->prepareForResponse($productGroup));
    }

    /**
     * @Route("/contractor-offer/{uuid}/product-group/create", name="api_create_offer_product_group")
     * @param $uuid
     * @param Request $request
     * @param ApiManager $apiManager
     * @param ContractorOfferManager $contractorOfferManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postCreateProductGroupOffer(
        $uuid, Request $request, ApiManager $apiManager, ContractorOfferManager $contractorOfferManager
    )
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $contractorOffer = $em->getRepository(ContractorOffer::class)->findOneBy([
            'uuid' => $uuid
        ]);

        $contractorOfferProductGroupData = new ContractorOfferProductGroupData();


        $form = $this->createForm(ContractorOfferProductGroupType::class, $contractorOfferProductGroupData);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $productGroupOffer = $apiManager->createProductGroupOffer($contractorOffer, $form->getData());
            $response = $contractorOfferManager->prepareForResponse($productGroupOffer->getContractorOffer());
        }else{
            $response = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $this->getErrorsFromForm($form)
            ];
            return new JsonResponse($response, 400);
        }

        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/contractor-offer/{uuid}/product-group/{id}/edit", name="api_edit_offer_product_group")
     * @param $uuid
     * @param Request $request
     * @param ApiManager $apiManager
     * @param ContractorOfferManager $contractorOfferManager
     * @param ProductGroup|null $productGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postUpdateProductGroupOffer(
        $uuid, Request $request, ApiManager $apiManager, ContractorOfferManager $contractorOfferManager,
        ProductGroup $productGroup = null
    )
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $contractorOffer = $em->getRepository(ContractorOffer::class)->findOneBy([
            'uuid' => $uuid
        ]);

        $contractorOfferProductGroup = null;

        foreach ($productGroup->getContractorOfferProductGroups()->toArray() as $contractorOfferProductGroupObj){
            if($contractorOfferProductGroupObj->getContractorOffer()->getId() === $contractorOffer->getId()){
                $contractorOfferProductGroup = $contractorOfferProductGroupObj;
            }
        }
        if(is_null($contractorOfferProductGroup)){
            $response = [
                'type' => 'validation_error',
                'title' => 'Such offer group does not exist',
            ];
            return new JsonResponse($response, 400);
        }

        $editContractorOfferProductGroupData = ContractorOfferProductGroupData::fromContractorOfferProductGroup($contractorOfferProductGroup);


        $form = $this->createForm(ContractorOfferProductGroupType::class, $editContractorOfferProductGroupData);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $productGroupOffer = $apiManager->updateProductGroupOffer($contractorOfferProductGroup, $form->getData());

            $response = $contractorOfferManager->prepareForResponse($productGroupOffer->getContractorOffer());
        }else{
            $response = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $this->getErrorsFromForm($form)
            ];
            return new JsonResponse($response, 400);
        }

        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/contractor-offer/{uuid}/send", name="api_send_contractor_offer")
     * @param $uuid
     * @param ApiManager $apiManager
     * @param ContractorOfferManager $contractorOfferManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendContractorOffer(
        $uuid, ApiManager $apiManager, ContractorOfferManager $contractorOfferManager
    )
    {
        $em = $this->getDoctrine()->getManager();

        $contractorOffer = $em->getRepository(ContractorOffer::class)->findOneBy([
            'uuid' => $uuid
        ]);
        $contractorOffer = $apiManager->setContractorOfferStatusToSent($contractorOffer);

        return new JsonResponse($contractorOfferManager->prepareForResponse($contractorOffer));
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

}
