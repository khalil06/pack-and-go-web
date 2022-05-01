<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions3Controller extends AbstractController
{
    /**
     * @Route("/questions3", name="app_questions3")
     */
    public function index(): Response
    {
        return $this->render('questions3/index.html.twig', [
            'controller_name' => 'Questions3Controller',
        ]);
    }
}
