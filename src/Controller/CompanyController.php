<?php

namespace App\Controller;

use App\Constants\FlashMessages;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Manager\CompanyManager;
use App\RequestData\CompanyData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company/list", name="company_list")
     * @param CompanyManager $companyManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanies(CompanyManager $companyManager)
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository(Company::class)->findAll();

        return $this->render('company/list.html.twig', [
            'companies' => $companyManager->prepareListForResponse($companies),
        ]);
    }

    /**
     * @Route("/company/{id}/view", name="company_view")
     * @param $id
     * @param CompanyManager $companyManager
     * @param Company|null $company
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompany($id, CompanyManager $companyManager, Company $company = null)
    {
        if (!$company) {
            return new JsonResponse(
                new EntityNotFoundModel('Company with id: ' . $id . ' does not exist', 404)
            );
        }

        return $this->render('company/view.html.twig', [
            'company' => $companyManager->prepareForResponse($company),
        ]);
    }


    /**
     * @Route("/company/create", name="company_create")
     * @param Request $request
     * @param CompanyManager $companyManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createCompany(Request $request, CompanyManager $companyManager)
    {
        $createCompanyData = new CompanyData();

        $form = $this->createForm(CompanyType::class, $createCompanyData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company = $companyManager->create($form->getData());

            $this->addFlash('success', FlashMessages::COMPANY_CREATE_SUCCESS);
            return $this->redirectToRoute('company_view', [
                'id' => $company->getId()
            ]);
        }

        return $this->render('company/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/company/{id}/edit", name="company_edit")
     * @param $id
     * @param Request $request
     * @param CompanyManager $companyManager
     * @param Company|null $company
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCompany($id, Request $request, CompanyManager $companyManager, Company $company = null)
    {
        if (!$company) {
            return new JsonResponse(
                new EntityNotFoundModel('Company with id: ' . $id . ' does not exist', 404)
            );
        }
        $editCompanyData = CompanyData::fromCompany($company);

        $form = $this->createForm(CompanyType::class, $editCompanyData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company = $companyManager->update($company, $form->getData());

            $this->addFlash('success', FlashMessages::COMPANY_UPDATE_SUCCESS);
            return $this->redirectToRoute('company_view', [
                'id' => $company->getId()
            ]);
        }

        return $this->render('company/edit.html.twig', [
            'form' => $form->createView(),
            'company' => $company
        ]);
    }

    /**
     * @Route("/company/{id}/delete", name="company_delete")
     * @param $id
     * @param CompanyManager $companyManager
     * @param Company|null $company
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteCompany($id, CompanyManager $companyManager, Company $company = null)
    {
        if (!$company) {
            return new JsonResponse(
                new EntityNotFoundModel('Company with id: ' . $id . ' does not exist', 404)
            );
        }

        $companyManager->delete($company);
        $this->addFlash('success', FlashMessages::COMPANY_DELETE_SUCCESS);

        return $this->redirectToRoute('company_list');
    }
}
