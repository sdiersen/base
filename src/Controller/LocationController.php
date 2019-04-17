<?php

namespace App\Controller;

use App\Entity\Helpers\Address;
use App\Entity\Helpers\Phone;
use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/location")
 */
class LocationController extends AbstractController
{
    /**
     * @Route("/", name="location_index", methods="GET")
     */
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="location_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $location = new Location();
        $address = new Address();
        $phone = new Phone();

        if($request->isMethod("POST")) {
            $location->setName($request->request->get("locationName"));
            $address->setStreetOne($request->request->get("addressStreetOne"));
            $address->setStreetTwo($request->request->get("addressStreetTwo"));
            $address->setCity($request->request->get("addressCity"));
            $address->setState($request->request->get("addressState"));
            $address->setZip($request->request->get("addressZip"));
            $phone->setNumber($request->request->get("phoneNumber"));

            $location->addAddress($address);
            $location->addPhone($phone);

            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->persist($phone);
            $em->persist($location);
            $em->flush();

            return $this->render('location/index.html.twig');
        }


        return $this->render('location/new.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}", name="location_show", methods="GET")
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', ['location' => $location]);
    }

    /**
     * @Route("/{id}/edit", name="location_edit", methods="GET|POST")
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_index', ['id' => $location->getId()]);
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="location_delete", methods="DELETE")
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($location);
            $em->flush();
        }

        return $this->redirectToRoute('location_index');
    }
}
