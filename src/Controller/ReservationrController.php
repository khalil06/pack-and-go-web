<?php

namespace App\Controller;

use App\Entity\Reservationr;
use App\Entity\Resteau;

use App\Entity\User;
use App\Form\RestauUpdateForm;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ReservationRType;
use App\Repository\ReservationRRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationrController extends AbstractController
{
    /**
     * @Route("/reservationr", name="app_reservationr")
     */
    public function index(): Response
    {
        return $this->render('reservationr/index.html.twig', [
            'controller_name' => 'ReservationrController',
        ]);
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * @Route ("/addreservation",name="reserver")
     */
    public function ajouterreservation(\Symfony\Component\HttpFoundation\Request $request)
    {
        $Reservationr = new ReservationR();
        $id=$_GET['id'];

        $liste = $this->getDoctrine()->getRepository(Resteau::class)->find($id);
        $list = $this->getDoctrine()->getRepository(User::class)->find(1);

        $form = $this->createForm(ReservationRType::class, $Reservationr);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $Reservationr->setIdR($liste);
            $Reservationr->setIdUser($list);

            $em = $this->getDoctrine()->getManager();
            $em->persist($Reservationr);
            $em->flush();

        }
        return $this->render("reservationr/addreservation.html.twig", array('formm' => $form->createView(),'imgr'=>$liste->getImgr(),'idUser'=>$list));


    }

    /**
     * @return Response
     * @Route ("/aff",name="affichee")
     */
    function afficher()
    {


        $liste = $this->getDoctrine()->getRepository(Reservationr::class)->findall();
        $liste1 = $this->getDoctrine()->getRepository(Resteau::class)->findall();
        return $this->render('reservationr/reservBack.html.twig', ['products' => $liste,'tabResteau' => $liste1]);




    }
    /**
     * @return Response
     * @Route ("/deleteRv/{idreservationr}",name="removReserv")
     */
    public function deleteR($idreservationr)
    {
        {
            $obsupp= $this->getDoctrine()->getRepository(Reservationr::class)->find($idreservationr);
            $em=$this->getDoctrine()->getManager();
            $em->remove($obsupp);
            $em->flush();

            return $this->redirectToRoute('affichee');
        }
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateRr/{idreservationr}",name="updateR")
     */
    public function updateReserv(\Symfony\Component\HttpFoundation\Request $request, $idreservationr)
    {
        $Reservationr=$this->getDoctrine()->getRepository(Reservationr::class)->find($idreservationr);

        $form = $this->createForm(ReservationRType::class, $Reservationr);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('affichee');
        }
        return $this->render("reservationr/updaterserv.html.twig", [
            'formm' => $form->createView()
        ]);    }

}
