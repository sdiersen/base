<?php

namespace App\Controller\Swim;

use App\Entity\Swim\ScheduledLesson;
use App\Form\Swim\ScheduledLessonType;
use App\Repository\Swim\ScheduledLessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/swim/scheduled/lesson")
 */
class ScheduledLessonController extends AbstractController
{
    /**
     * @Route("/", name="swim_scheduled_lesson_index", methods="GET")
     */
    public function index(ScheduledLessonRepository $scheduledLessonRepository): Response
    {
        return $this->render('swim/scheduled_lesson/index.html.twig', ['scheduled_lessons' => $scheduledLessonRepository->findAll()]);
    }

    /**
     * @Route("/new", name="swim_scheduled_lesson_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $scheduledLesson = new ScheduledLesson();
        $form = $this->createForm(ScheduledLessonType::class, $scheduledLesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduledLesson);
            $em->flush();

            return $this->redirectToRoute('swim_scheduled_lesson_index');
        }

        return $this->render('swim/scheduled_lesson/new.html.twig', [
            'scheduled_lesson' => $scheduledLesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="swim_scheduled_lesson_show", methods="GET")
     */
    public function show(ScheduledLesson $scheduledLesson): Response
    {
        return $this->render('swim/scheduled_lesson/show.html.twig', ['scheduled_lesson' => $scheduledLesson]);
    }

    /**
     * @Route("/{id}/edit", name="swim_scheduled_lesson_edit", methods="GET|POST")
     */
    public function edit(Request $request, ScheduledLesson $scheduledLesson): Response
    {
        $form = $this->createForm(ScheduledLessonType::class, $scheduledLesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('swim_scheduled_lesson_index', ['id' => $scheduledLesson->getId()]);
        }

        return $this->render('swim/scheduled_lesson/edit.html.twig', [
            'scheduled_lesson' => $scheduledLesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="swim_scheduled_lesson_delete", methods="DELETE")
     */
    public function delete(Request $request, ScheduledLesson $scheduledLesson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scheduledLesson->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scheduledLesson);
            $em->flush();
        }

        return $this->redirectToRoute('swim_scheduled_lesson_index');
    }
}
