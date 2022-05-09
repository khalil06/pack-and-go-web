<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteInteractionController extends AbstractController
{
    /**
     * @Route("/delete/interaction/{id}", name="app_delete_interaction")
     */
    public function index(string $id): Response
    {
        $interactionStyle=$this->getDoctrine()->getRepository(InteractionStyle::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($interactionStyle);
        $manager->flush();
        return $this->redirectToRoute('app_dashboard_table');
        return $this->render('delete_interaction/index.html.twig', [
            'controller_name' => 'DeleteInteractionController',
        ]);
    }
}
