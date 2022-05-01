<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions1Controller extends AbstractController
{
    /**
     * @Route("/questions1", name="app_questions1")
     */
    public function index(): Response
    {
        return $this->render('questions1/index.html.twig', [
            'controller_name' => 'Questions1Controller',
        ]);
    }
}
