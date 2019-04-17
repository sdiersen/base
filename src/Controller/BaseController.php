<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base_homepage")
     */
    public function homepage()
    {
        return $this->render('base/homepage.html.twig', [

        ]);
    }

    /**
     * @Route("/buffalo", name="base_buffalo")
     */
    public function buffalo()
    {
        return $this->render('base/buffalo.html.twig', [

        ]);
    }

    /**
     * @Route("/monticello", name="base_monticello")
     */
    public function monticello()
    {
        return $this->render('base/monticello.html.twig', [

        ]);
    }

    /**
     * @Route("/zimmerman", name="base_zimmerman")
     */
    public function zimmerman()
    {
        return $this->render('base/zimmerman.html.twig', [

        ]);
    }

}
