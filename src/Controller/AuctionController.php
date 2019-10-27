<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Auction;
use App\Entity\ProductColumn;
use App\Form\AuctionType;
use App\Manager\AuctionManager;
use App\Manager\ProductManager;
use App\RequestData\AuctionData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuctionController extends AbstractController
{
    /**
     * @Route("/auction/list", name="auction_list", methods={"GET"})
     * @param AuctionManager $auctionManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAuctions(AuctionManager $auctionManager)
    {
        $em = $this->getDoctrine()->getManager();

        $activeAuctions = $em->getRepository(Auction::class)->findActiveAuctions();
        $draftAuctions = $em->getRepository(Auction::class)->findDraftAuctions();

        $auctionManager->updateFinishedAuctionsStatus($activeAuctions);

        $finishedAuctions = $em->getRepository(Auction::class)->findFinishedAuctions();

        return $this->render('auction/list.html.twig', [
            'activeAuctions' => $auctionManager->prepareListForResponse($activeAuctions),
            'draftAuctions' => $auctionManager->prepareListForResponse($draftAuctions),
            'finishedAuctions' => $auctionManager->prepareListForResponse($finishedAuctions),
        ]);
    }

    /**
     * @Route("/auction/{id}/view", name="auction_view")
     * @param $id
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAuction(
        $id, AuctionManager $auctionManager, ProductManager $productManager, Auction $auction = null
    )
    {
        if (!$auction) {
            return new JsonResponse(
                new EntityNotFoundMyException('Auction with id: ' . $id . ' does not exist', 404)
            );
        }

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        return $this->render('auction/view.html.twig', [
            'auction' => $auctionManager->prepareForResponse($auction),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }


    /**
     * @Route("/auction/create", name="auction_create")
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
     * @Route("/auction/{id}/edit", name="auction_edit")
     * @param Request $request
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAuction(
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

    /**
     * @Route("/auction/{id}/start", name="auction_start")
     * @param $id
     * @param AuctionManager $auctionManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function startAuction($id, AuctionManager $auctionManager, Auction $auction = null)
    {
        if (!$auction) {
            return new JsonResponse(
                new EntityNotFoundMyException('Auction with id: ' . $id . ' does not exist', 404)
            );
        }

        $started = $auctionManager->start($auction);

        if($started){
            $this->addFlash('success', FlashMessages::AUCTION_START_SUCCESS);
        }else{
            $this->addFlash('success', FlashMessages::AUCTION_START_FAILED);
        }

        return $this->redirectToRoute('auction_list');
    }

    /**
     * @Route("/auction/{id}/delete", name="auction_delete")
     * @param $id
     * @param AuctionManager $auctionManager
     * @param Auction|null $auction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAuction($id, AuctionManager $auctionManager, Auction $auction = null)
    {
        if (!$auction) {
            return new JsonResponse(
                new EntityNotFoundMyException('Auction with id: ' . $id . ' does not exist', 404)
            );
        }

        $auctionManager->delete($auction);
        $this->addFlash('success', FlashMessages::AUCTION_DELETE_SUCCESS);

        return $this->redirectToRoute('auction_list');
    }
}
