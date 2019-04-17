<?php

namespace App\Controller\Test;



use App\Entity\Test\Task;
use App\Form\Test\TaskType;
use App\Repository\Test\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller\Test
 * @Route("/test")
 */
class TaskController extends AbstractController
{

    /**
     * @param TaskRepository $taskRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="test_index")
     */
    public function index(TaskRepository $taskRepository)
    {
        return $this->render('test/task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("/new", name="test_new")
     */
    public function new(Request $request)
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('test_index');

        }

        return $this->render('test/task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}