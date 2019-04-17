<?php

namespace App\Controller\Swim;

use App\Entity\Swim\Lesson;
use App\Form\Swim\LessonType;
use App\Repository\Swim\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/swim/lesson")
 */
class LessonController extends AbstractController
{
    /**
     * @Route("/", name="swim_lesson_index", methods="GET")
     */
    public function index(LessonRepository $lessonRepository): Response
    {
        return $this->render('swim/lesson/index.html.twig', ['lessons' => $lessonRepository->findAll()]);
    }

    /**
     * @Route("/new", name="swim_lesson_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('swim_lesson_index');
        }

        return $this->render('swim/lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="swim_lesson_show", methods="GET")
     */
    public function show(Lesson $lesson): Response
    {
        return $this->render('swim/lesson/show.html.twig', ['lesson' => $lesson]);
    }

    /**
     * @Route("/{id}/edit", name="swim_lesson_edit", methods="GET|POST")
     */
    public function edit(Request $request, Lesson $lesson): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('swim_lesson_index', ['id' => $lesson->getId()]);
        }

        return $this->render('swim/lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="swim_lesson_delete", methods="DELETE")
     */
    public function delete(Request $request, Lesson $lesson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lesson);
            $em->flush();
        }

        return $this->redirectToRoute('swim_lesson_index');
    }
}
