<?php

namespace App\Controller;

use App\Constants\ContractorOfferStatus;
use App\Constants\FlashMessages;
use App\Entity\Auction;
use App\Entity\ContractorOffer;
use App\Entity\ProductColumn;
use App\Form\ContractorOfferType;
use App\Manager\AuctionManager;
use App\Manager\ContractorOfferManager;
use App\Manager\ProductManager;
use App\RequestData\ContractorOfferData;
use App\Service\DataFormation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    /**
     * @Route("/offer/{uuid}", name="offer_create")
     * @param $uuid
     * @param Request $request
     * @param ContractorOfferManager $contractorOfferManager
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createOffer(
        $uuid, Request $request, ContractorOfferManager $contractorOfferManager, AuctionManager $auctionManager,
        ProductManager $productManager
    )
    {
        $auction = $this->getDoctrine()->getRepository(Auction::class)->findOneBy(
            [
                'uuid' => $uuid
            ]
        );
        if(is_null($auction)){
            dump('no such auction');
            die;
        }

        if($auction->getEndDate() < (new \DateTime('now'))){
            dump('auction already finished');
            die;
        }

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        $createAuctionData = new ContractorOfferData();

        $form = $this->createForm(ContractorOfferType::class, $createAuctionData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractorOffer = $contractorOfferManager->create($auction, $form->getData());

            if(!$contractorOffer){
                $this->addFlash('success', FlashMessages::AUCTION_CREATE_FAILED);

                return $this->render('offer/create.html.twig', [
                    'form' => $form->createView(),
                    'auction' => $auctionManager->prepareForResponse($auction),
                    'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
                ]);
            }
            $this->addFlash('success', FlashMessages::AUCTION_CREATE_SUCCESS);

            return $this->redirectToRoute('offer_product_groups', [
                'uuid' => $contractorOffer->getUuid(),
            ]);
        }

        return $this->render('offer/create.html.twig', [
            'form' => $form->createView(),
            'auction' => $auctionManager->prepareForResponse($auction),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }


    /**
     * @Route("/contractor-offer/{uuid}", name="offer_product_groups")
     * @param $uuid
     * @param Request $request
     * @param ContractorOfferManager $contractorOfferManager
     * @param AuctionManager $auctionManager
     * @param ProductManager $productManager
     * @param DataFormation $formation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createOfferProductGroups(
        $uuid, Request $request, ContractorOfferManager $contractorOfferManager, AuctionManager $auctionManager,
        ProductManager $productManager, DataFormation $formation
    )
    {
        $contractorOffer = $this->getDoctrine()->getRepository(ContractorOffer::class)->findOneBy(
            [
                'uuid' => $uuid
            ]
        );
        if(is_null($contractorOffer)){
            dump('no such offer');
            die;
        }

        if($contractorOffer->getStatus() >= ContractorOfferStatus::SENT){
            dump('wysłano');
            die;
        }

        $offerGroupsData = $formation->formOfferProductGroupData($contractorOffer);

        $productColumns = $this->getDoctrine()->getRepository(ProductColumn::class)->findAll();

        $editContractorOfferData = ContractorOfferData::fromContractorOffer($contractorOffer);

        $form = $this->createForm(ContractorOfferType::class, $editContractorOfferData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractorOffer = $contractorOfferManager->update($contractorOffer, $form->getData());

            if(!$contractorOffer){
                $this->addFlash('success', FlashMessages::AUCTION_CREATE_FAILED);

                return $this->render('offer/create.html.twig', [
                    'form' => $form->createView(),
                    'auction' => $auctionManager->prepareForResponse($contractorOffer->getAuction()),
                    'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
                ]);
            }
            $this->addFlash('success', FlashMessages::AUCTION_CREATE_SUCCESS);

            return $this->redirectToRoute('offer_product_groups', [
                'uuid' => $contractorOffer->getUuid(),
            ]);
        }

        return $this->render('offer/product-groups.html.twig', [
            'form' => $form->createView(),
            'contractorOfferGroupData' => $offerGroupsData,
            'contractorOfferUuid' => $uuid,
            'auction' => $auctionManager->prepareForResponse($contractorOffer->getAuction()),
            'columns' => $productManager->prepareProductColumnListForResponse($productColumns),
        ]);
    }
}
