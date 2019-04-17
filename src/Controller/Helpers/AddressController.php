<?php

namespace App\Controller\Helpers;

use App\Entity\Helpers\Address;
use App\Form\Helpers\AddressType;
use App\Repository\Helpers\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/helpers/address")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="helpers_address_index", methods="GET")
     */
    public function index(AddressRepository $addressRepository): Response
    {
        return $this->render('helpers/address/index.html.twig', ['addresses' => $addressRepository->findAll()]);
    }

    /**
     * @Route("/new", name="helpers_address_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('helpers_address_index');
        }

        return $this->render('helpers/address/new.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="helpers_address_show", methods="GET")
     */
    public function show(Address $address): Response
    {
        return $this->render('helpers/address/show.html.twig', ['address' => $address]);
    }

    /**
     * @Route("/{id}/edit", name="helpers_address_edit", methods="GET|POST")
     */
    public function edit(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('helpers_address_index', ['id' => $address->getId()]);
        }

        return $this->render('helpers/address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="helpers_address_delete", methods="DELETE")
     */
    public function delete(Request $request, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush();
        }

        return $this->redirectToRoute('helpers_address_index');
    }
}
