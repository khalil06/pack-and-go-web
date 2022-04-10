<?php

namespace App\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Resteau;
use App\Form\RestauFormType;
use App\Form\RestauUpdateForm;
use App\Repository\RestauRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Form\FormBuilderInterface;
class RestauController extends AbstractController
{
    /**
     * @Route("/restau", name="app_restau")
     */
    public function index(): Response
    {
        return $this->render('restau/index.html.twig', [
            'controller_name' => 'RestauController',
        ]);
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/AddR",name="Ajoutrest")
     */
    public function ajouterRestau(\Symfony\Component\HttpFoundation\Request $request)
    {
        $Resteau = new Resteau();
        $form = $this->createForm(RestauFormType::class, $Resteau);
       $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $file = $Resteau->getNomr() . ('uploads').'/'.'.jpg';

            $Resteau->setImgr($file);

            $em = $this->getDoctrine()->getManager();
            $em->persist($Resteau);
            $em->flush();
         return $this->redirectToRoute('affiche');
        }
        return $this->render("restau/index.html.twig", [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route ("/afficheR",name="affiche")
     *
     */

    function affichageRestau()
    {


        $liste = $this->getDoctrine()->getRepository(Resteau::class)->findall();

        return $this->render('restau/affichageRestau.html.twig', ['tabResteau' => $liste]);


    }

    /**
     * @return Response
     * @Route ("/deleteR/{idr}",name="supp")
     */
    public function deleteRestau($idr)
    {
        {
            $objsupp=$this->getDoctrine()->getRepository(Resteau::class)->find($idr);
            $em=$this->getDoctrine()->getManager();
            $em->remove($objsupp);
            $em->flush();

            return $this->redirectToRoute('affiche');
        }
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateR/{idr}",name="update")
     */
    public function updateRestau(Request $request,$idr)
    {
        $Resteau=$this->getDoctrine()->getRepository(Resteau::class)->find($idr);

        $form = $this->createForm(RestauUpdateForm::class, $Resteau);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('affiche');
        }
        return $this->render("restau/updaterestau.html.twig", [
            'form' => $form->createView()
        ]);    }
    /**

     * @Route ("/affRF",name="afficheF")
     *
     */
    public function affR()
    {

        $liste = $this->getDoctrine()->getRepository(Resteau::class)->findall();

        return $this->render('restau/affichageRestauFront.html.twig', ['tabResteau' => $liste]);


    }
    /**

     * @Route ("/Homee",name="homee")
     *
     */
    public function  Home()
{
                    //  $liste = $this->getDoctrine()->getRepository(Resteau::class)->findall();

                return $this->render('restau/HomeFront.html.twig');


}

}
