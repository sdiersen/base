<?php

namespace App\Controller\Helpers;

use App\Entity\Helpers\Phone;
use App\Form\Helpers\PhoneType;
use App\Repository\Helpers\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/helpers/phone")
 */
class PhoneController extends AbstractController
{
    /**
     * @Route("/", name="helpers_phone_index", methods="GET")
     */
    public function index(PhoneRepository $phoneRepository): Response
    {
        return $this->render('helpers/phone/index.html.twig', ['phones' => $phoneRepository->findAll()]);
    }

    /**
     * @Route("/new", name="helpers_phone_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $phone = new Phone();
        $form = $this->createForm(PhoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute('helpers_phone_index');
        }

        return $this->render('helpers/phone/new.html.twig', [
            'phone' => $phone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="helpers_phone_show", methods="GET")
     */
    public function show(Phone $phone): Response
    {
        return $this->render('helpers/phone/show.html.twig', ['phone' => $phone]);
    }

    /**
     * @Route("/{id}/edit", name="helpers_phone_edit", methods="GET|POST")
     */
    public function edit(Request $request, Phone $phone): Response
    {
        $form = $this->createForm(PhoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('helpers_phone_index', ['id' => $phone->getId()]);
        }

        return $this->render('helpers/phone/edit.html.twig', [
            'phone' => $phone,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="helpers_phone_delete", methods="DELETE")
     */
    public function delete(Request $request, Phone $phone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phone->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($phone);
            $em->flush();
        }

        return $this->redirectToRoute('helpers_phone_index');
    }
}
