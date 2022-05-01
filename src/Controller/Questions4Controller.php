<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions4Controller extends AbstractController
{
    /**
     * @Route("/questions4", name="app_questions4")
     */
    public function index(): Response
    {
        return $this->render('questions4/index.html.twig', [
            'controller_name' => 'Questions4Controller',
        ]);
    }
}
