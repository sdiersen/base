<?php

namespace App\Controller\Events;

use App\Entity\Events\ScheduledEvent;
use App\Form\Events\ScheduledEventType;
use App\Repository\Events\ScheduledEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/events/scheduled/event")
 */
class ScheduledEventController extends AbstractController
{
    /**
     * @Route("/", name="events_scheduled_event_index", methods="GET")
     */
    public function index(ScheduledEventRepository $scheduledEventRepository): Response
    {
        return $this->render('events/scheduled_event/index.html.twig', ['scheduled_events' => $scheduledEventRepository->findAll()]);
    }

    /**
     * @Route("/new", name="events_scheduled_event_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $scheduledEvent = new ScheduledEvent();
        $form = $this->createForm(ScheduledEventType::class, $scheduledEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduledEvent);
            $em->flush();

            return $this->redirectToRoute('events_scheduled_event_index');
        }

        return $this->render('events/scheduled_event/new.html.twig', [
            'scheduled_event' => $scheduledEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_scheduled_event_show", methods="GET")
     */
    public function show(ScheduledEvent $scheduledEvent): Response
    {
        return $this->render('events/scheduled_event/show.html.twig', ['scheduled_event' => $scheduledEvent]);
    }

    /**
     * @Route("/{id}/edit", name="events_scheduled_event_edit", methods="GET|POST")
     */
    public function edit(Request $request, ScheduledEvent $scheduledEvent): Response
    {
        $form = $this->createForm(ScheduledEventType::class, $scheduledEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_scheduled_event_index', ['id' => $scheduledEvent->getId()]);
        }

        return $this->render('events/scheduled_event/edit.html.twig', [
            'scheduled_event' => $scheduledEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="events_scheduled_event_delete", methods="DELETE")
     */
    public function delete(Request $request, ScheduledEvent $scheduledEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scheduledEvent->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scheduledEvent);
            $em->flush();
        }

        return $this->redirectToRoute('events_scheduled_event_index');
    }
}
