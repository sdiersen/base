<?php

namespace App\Controller\Gx;

use App\Entity\Gx\GxClass;
use App\Form\Gx\GxClassType;
use App\Repository\Gx\GxClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gx/gx/class")
 */
class GxClassController extends AbstractController
{
    /**
     * @Route("/", name="gx_gx_class_index", methods="GET")
     */
    public function index(GxClassRepository $gxClassRepository): Response
    {
        return $this->render('gx/gx_class/index.html.twig', ['gx_classes' => $gxClassRepository->findAll()]);
    }

    /**
     * @Route("/new", name="gx_gx_class_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $gxClass = new GxClass();
        $form = $this->createForm(GxClassType::class, $gxClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gxClass);
            $em->flush();

            return $this->redirectToRoute('gx_gx_class_index');
        }

        return $this->render('gx/gx_class/new.html.twig', [
            'gx_class' => $gxClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gx_gx_class_show", methods="GET")
     */
    public function show(GxClass $gxClass): Response
    {
        return $this->render('gx/gx_class/show.html.twig', ['gx_class' => $gxClass]);
    }

    /**
     * @Route("/{id}/edit", name="gx_gx_class_edit", methods="GET|POST")
     */
    public function edit(Request $request, GxClass $gxClass): Response
    {
        $form = $this->createForm(GxClassType::class, $gxClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gx_gx_class_index', ['id' => $gxClass->getId()]);
        }

        return $this->render('gx/gx_class/edit.html.twig', [
            'gx_class' => $gxClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gx_gx_class_delete", methods="DELETE")
     */
    public function delete(Request $request, GxClass $gxClass): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gxClass->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gxClass);
            $em->flush();
        }

        return $this->redirectToRoute('gx_gx_class_index');
    }
}
