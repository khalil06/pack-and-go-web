<?php

namespace App\Controller;

use App\Entity\SocialStyle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteSocialController extends AbstractController
{
    /**
     * @Route("/delete/social/{id}", name="app_delete_social")
     */
    public function index(string $id): Response
    {
        $socialStyle=$this->getDoctrine()->getRepository(SocialStyle::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($socialStyle);
        $manager->flush();
        return $this->redirectToRoute('app_dashboard_table');
        return $this->render('delete_social/index.html.twig', [
            'controller_name' => 'DeleteSocialController',
        ]);
    }
}
