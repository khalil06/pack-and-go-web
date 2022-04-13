<?php

namespace App\Controller;

use App\Entity\Reservationchambre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
