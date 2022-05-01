<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions2Controller extends AbstractController
{
    /**
     * @Route("/questions2", name="app_questions2")
     */
    public function index(): Response
    {
        return $this->render('questions2/index.html.twig', [
            'controller_name' => 'Questions2Controller',
        ]);
    }
}
