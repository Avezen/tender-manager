<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Manager\LocationManager;
use App\RequestData\LocationData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    /**
     * @Route("/location/list", name="location_list")
     * @param LocationManager $locationManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getLocations(LocationManager $locationManager)
    {
        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository(Location::class)->findAll();

        return $this->render('location/list.html.twig', [
            'locations' => $locationManager->prepareListForResponse($locations),
        ]);
    }

    /**
     * @Route("/location/{id}/view", name="location_view")
     * @param $id
     * @param LocationManager $locationManager
     * @param Location|null $location
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getLocation($id, LocationManager $locationManager, Location $location = null)
    {
        if (!$location) {
            return new JsonResponse(
                new EntityNotFoundModel('Location with id: ' . $id . ' does not exist', 404)
            );
        }

        return $this->render('location/view.html.twig', [
            'location' => $locationManager->prepareForResponse($location),
        ]);
    }


    /**
     * @Route("/location/create", name="location_create")
     * @param Request $request
     * @param LocationManager $locationManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createLocation(Request $request, LocationManager $locationManager)
    {
        $createLocationData = new LocationData();

        $form = $this->createForm(LocationType::class, $createLocationData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location = $locationManager->create($form->getData());

            $this->addFlash('success', 'Pomyślnie dodano lokalizację');

            return $this->redirectToRoute('location_view', [
                'id' => $location->getId()
            ]);
        }

        return $this->render('location/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/location/{id}/edit", name="location_edit")
     * @param $id
     * @param Request $request
     * @param LocationManager $locationManager
     * @param Location|null $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editLocation($id, Request $request, LocationManager $locationManager, Location $location = null)
    {
        if (!$location) {
            return new JsonResponse(
                new EntityNotFoundModel('Location with id: ' . $id . ' does not exist', 404)
            );
        }

        $editLocationData = LocationData::fromLocation($location);

        $form = $this->createForm(LocationType::class, $editLocationData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location = $locationManager->update($location, $form->getData());

            $this->addFlash('success', 'Pomyślnie zaktualizowano lokalizację');

            return $this->redirectToRoute('location_view', [
                'id' => $location->getId()
            ]);
        }

        return $this->render('location/edit.html.twig', [
            'form' => $form->createView(),
            'location' => $location
        ]);
    }

    /**
     * @Route("/location/{id}/delete", name="location_delete")
     * @param $id
     * @param LocationManager $locationManager
     * @param Location|null $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteLocation($id, LocationManager $locationManager, Location $location = null)
    {
        if (!$location) {
            return new JsonResponse(
                new EntityNotFoundModel('Location with id: ' . $id . ' does not exist', 404)
            );
        }

        $locationManager->delete($location);
        $this->addFlash('success', 'Pomyślnie usunięto lokalizację');

        return $this->redirectToRoute('location_list');
    }
}
