<?php

namespace App\Controller;
use App\Entity\Resteau;
use App\Entity\Commentaire;
use App\Form\CommentaireType;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/addcommentaire",name="commenter")
     */
    public function ajouterreservation(\Symfony\Component\HttpFoundation\Request $request)
    {

        $Commentaire = new Commentaire();
        $id=$_GET['id'];

        $liste = $this->getDoctrine()->getRepository(Resteau::class)->find($id);
        $idd=$liste->getIdr();
        $liste2 = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(array('idr'=> $liste));


        $form = $this->createForm(CommentaireType::class, $Commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $Commentaire->setIdr($liste);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Commentaire);
            $em->flush();

        }

        return $this->render("commentaire/addcommentaire.html.twig", array('form' => $form->createView(),'image'=>$liste->getImgR(),'tab'=>$liste2));



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
