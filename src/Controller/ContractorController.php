<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Contractor;
use App\Form\ContractorType;
use App\Manager\ContractorManager;
use App\RequestData\ContractorData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContractorController extends AbstractController
{
    /**
     * @Route("/contractor/list", name="contractor_list")
     * @param ContractorManager $contractorManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getContractors(ContractorManager $contractorManager)
    {
        $em = $this->getDoctrine()->getManager();

        $contractors = $em->getRepository(Contractor::class)->findAll();

        dump($contractors[4]->getContractorOffers()->toArray()[0]->getContractorOfferProductGroups()->toArray()[0]->getContractorOfferProductGroupProducts()->toArray());
        die;

        return $this->render('contractor/list.html.twig', [
            'contractors' => $contractorManager->prepareListForResponse($contractors),
        ]);
    }

    /**
     * @Route("/contractor/{id}/view", name="contractor_view")
     * @param $id
     * @param ContractorManager $contractorManager
     * @param Contractor|null $contractor
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getContractor($id, ContractorManager $contractorManager, Contractor $contractor = null)
    {
        if (!$contractor) {
            return new JsonResponse(
                new EntityNotFoundModel('Contractor with id: ' . $id . ' does not exist', 404)
            );
        }

        return $this->render('contractor/view.html.twig', [
            'contractor' => $contractorManager->prepareForResponse($contractor),
        ]);
    }


    /**
     * @Route("/contractor/create", name="contractor_create")
     * @param Request $request
     * @param ContractorManager $contractorManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createContractor(Request $request, ContractorManager $contractorManager)
    {
        $createContractorData = new ContractorData();

        $form = $this->createForm(ContractorType::class, $createContractorData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractor = $contractorManager->create($form->getData());

            $this->addFlash('success', FlashMessages::CONTRACTOR_CREATE_SUCCESS);
            return $this->redirectToRoute('contractor_view', [
                'id' => $contractor->getId()
            ]);
        }

        return $this->render('contractor/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contractor/{id}/edit", name="contractor_edit")
     * @param $id
     * @param Request $request
     * @param ContractorManager $contractorManager
     * @param Contractor|null $contractor
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editContractor($id, Request $request, ContractorManager $contractorManager, Contractor $contractor = null)
    {
        if (!$contractor) {
            return new JsonResponse(
                new EntityNotFoundModel('Contractor with id: ' . $id . ' does not exist', 404)
            );
        }

        $editContractorData = ContractorData::fromContractor($contractor);

        $form = $this->createForm(ContractorType::class, $editContractorData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractor = $contractorManager->update($contractor, $form->getData());

            $this->addFlash('success', FlashMessages::CONTRACTOR_UPDATE_SUCCESS);
            return $this->redirectToRoute('contractor_view', [
                'id' => $contractor->getId()
            ]);
        }

        return $this->render('contractor/edit.html.twig', [
            'form' => $form->createView(),
            'contractor' => $contractor
        ]);
    }

    /**
     * @Route("/contractor/{id}/delete", name="contractor_delete")
     * @param $id
     * @param ContractorManager $contractorManager
     * @param Contractor|null $contractor
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteContractor($id, ContractorManager $contractorManager, Contractor $contractor = null)
    {
        if (!$contractor) {
            return new JsonResponse(
                new EntityNotFoundModel('Contractor with id: ' . $id . ' does not exist', 404)
            );
        }

        if((count($contractor->getContractorOffers()->toArray()) > 0)){
            dump('failed');
            die;
            $this->addFlash('success', FlashMessages::CONTRACTOR_HAS_DATA);
        }else{
            dump('delete');
            die;
            $contractorManager->delete($contractor);
            $this->addFlash('success', FlashMessages::CONTRACTOR_DELETE_SUCCESS);
        }



        return $this->redirectToRoute('contractor_list');
    }
}
