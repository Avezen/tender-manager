<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Auction;
use App\Entity\Orders;
use App\Entity\ProductColumn;
use App\Form\AuctionType;
use App\Manager\AuctionManager;
use App\Manager\OrderManager;
use App\Manager\ProductManager;
use App\Model\Error\EntityNotFoundException;
use App\RequestData\AuctionData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/list", name="order_list", methods={"GET"})
     * @param OrderManager $orderManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrders(OrderManager $orderManager)
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository(Orders::class)->findAll();

        dump($orders);
        die;

        return $this->render('order/list.html.twig', [
            'orders' => $orderManager->prepareListForResponse($orders),
        ]);
    }

    /**
     * @Route("/order/{id}/view", name="order_view")
     * @param $id
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOrder(
        $id, AuctionManager $auctionManager, ProductManager $productManager, Auction $auction = null
    )
    {
        if (!$auction) {
            return new JsonResponse(
                new EntityNotFoundException('Auction with id: ' . $id . ' does not exist', 404)
            );
        }

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('auction/view.html.twig', [
            'auction' => $auctionManager->prepareForResponse($auction),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }


    /**
     * @Route("/order/create", name="order_create")
     * @param Request $request
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAuction(Request $request, AuctionManager $auctionManager, ProductManager $productManager)
    {
        $createAuctionData = new AuctionData();

        $form = $this->createForm(AuctionType::class, $createAuctionData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $auction = $auctionManager->create($form->getData());

            $this->addFlash('success', FlashMessages::AUCTION_CREATE_SUCCESS);

            return $this->redirectToRoute('auction_edit', [
                'id' => $auction->getId(),
            ]);
        }

        //dump((string) $form->getErrors(true, false));
        //die;

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('auction/create.html.twig', [
            'form' => $form->createView(),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }

    /**
     * @Route("/order/{id}/edit", name="order_edit")
     * @param Request $request
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editOrder(
        Request $request, AuctionManager $auctionManager, ProductManager $productManager, Auction $auction = null
    )
    {
        if (!$auction) {
            $this->addFlash('error', FlashMessages::AUCTION_NOT_EXIST);

            return $this->redirectToRoute('auction_list');
        }
        $editAuctionData = AuctionData::fromAuction($auction);

        $form = $this->createForm(AuctionType::class, $editAuctionData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $auction = $auctionManager->update($auction, $form->getData());

            $this->addFlash('success', FlashMessages::AUCTION_UPDATE_SUCCESS);

            return $this->redirectToRoute('auction_edit', [
                'id' => $auction->getId(),
            ]);
        }

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('auction/edit.html.twig', [
            'form' => $form->createView(),
            'auction' => $auctionManager->prepareForResponse($auction),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }

}
