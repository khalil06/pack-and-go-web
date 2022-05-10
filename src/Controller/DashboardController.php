<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/front", name="app_front")
     */
    public function front()
    {
        return $this->render('baseFront.html.twig');
    }
}
