<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Reservationchambre;
use App\Form\ReservChambreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationChambreController extends AbstractController
{
    /**
     * @Route("listReservChambres", name="listReservChambres")
     */
    public function index(): Response
    {
        $listReservCh = $this->getDoctrine()->getRepository(Reservationchambre::class)->findall();
        return $this->render('reservation_chambre/index.html.twig', ['reservChambre' => $listReservCh]);
    }

    /**
     * @Route("/deleteReservChambre/{id}", name="deleteReservChambre")
     */
    public function deleteReservChambre($id)
    {
        $reservCh = $this->getDoctrine()->getRepository(Reservationchambre::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservCh);
        $em->flush();
        return $this->redirectToRoute('listReservations');
    }

    /**
     * @Route("/reserverCh/{id}", name="reserverCh")
     * @param Request $request
     * @return Response

     */
    public function reserverChambre(Request $request):Response{
        $reservationCh = new Reservationchambre();
        $id= $request->get('id');
        $chambre = $this->getDoctrine()->getRepository(Chambre::class)->find($id);
        $form = $this->createForm(ReservChambreType::class, $reservationCh);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $reservationCh->setIdChambre($chambre);
            $reservationCh= $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservationCh);
            $em->flush();
            $this->addFlash('success', 'réservation effectuée avec succes! Merci davoir choisir pack & go');

        }
        return $this->render('reservation_chambre/reserverChambre.html.twig', [
            'form' => $form -> createView (),
        ]);

    }
}
