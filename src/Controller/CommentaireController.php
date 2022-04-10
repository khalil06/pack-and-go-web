<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="app_commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
    /**
     * @Route("/AfficheCmnt", name="AFFommentaire")
     */
    public  function  AfficherCommentaire() {
        $listeCmntr = $this->getDoctrine()->getRepository(Commentaire::class)->findall();
        return $this->render('Commentaire/affichageCommentaireBack.html.twig', ['tabCmntr' => $listeCmntr]);


    }
    /**
     * @return Response
     * @Route ("/deleteC/{idcommentairer}",name="suppC")
     */
    public function deleteCmntr($idcommentairer)
    {
        {
            $obsupp= $this->getDoctrine()->getRepository(Commentaire::class)->find($idcommentairer);
            $em=$this->getDoctrine()->getManager();
            $em->remove($obsupp);
            $em->flush();

            return $this->redirectToRoute('AFFommentaire');
        }
    }
}
