<?php

namespace App\Controller\Events;

use App\Entity\Events\Event;
use App\Form\Events\EventType;
use App\Repository\Events\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/events/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="events_event_index", methods="GET")
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('events/event/index.html.twig', ['events' => $eventRepository->findAll()]);
    }

    /**
     * @Route("/new", name="events_event_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('events_event_index');
        }

        return $this->render('events/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_event_show", methods="GET")
     */
    public function show(Event $event): Response
    {
        return $this->render('events/event/show.html.twig', ['event' => $event]);
    }

    /**
     * @Route("/{id}/edit", name="events_event_edit", methods="GET|POST")
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_event_index', ['id' => $event->getId()]);
        }

        return $this->render('events/event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_event_delete", methods="DELETE")
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('events_event_index');
    }
}
