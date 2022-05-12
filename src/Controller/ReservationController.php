<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vol;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(Request $request,ReservationRepository $reservationRepository, PaginatorInterface $paginator): Response
    {
        $donnes=$reservationRepository->findAll();
        $reservation=$paginator->paginate(
            $donnes,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservation,
        ]);
    }

    /**
     * @Route("/new/{id_vol}", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id_vol): Response
    {
        $vol = $this->getDoctrine()
            ->getRepository(Vol::class)
            ->find($id_vol);
        $reservation = new Reservation();
        $reservation->setVol($vol);
        $reservation->setFinalPrice($reservation->getVol()->getInitialPrice());
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($reservation->getClass() =='Business class' )
            {
                $reservation->setFinalPrice($reservation->getFinalPrice()*2);
            }
            if($reservation->getType() == 'round trip'){
                $reservation->setFinalPrice($reservation->getFinalPrice()*1.5);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('confirm_reservation', ['reservation_id'=> $reservation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'vol'=>$vol
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/cancel/front/{id}", name="reservation_cancel_front", methods={"POST"})
     */
    public function cancelFront(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vol_index_front', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/new/confirm/{reservation_id}", name="confirm_reservation")
     */
    public function confirm($reservation_id): Response
    {
        $reservation = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->find($reservation_id);
        return $this->render('reservation/confirm.html.twig', [
            'reservation' => $reservation
        ]);
    }
    /**
     * @Route("/new/confirm/front/{reservation_id}", name="confirm_front_reservation")
     */
    public function confirmFront($reservation_id): Response
    {
        $reservation = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->find($reservation_id);
        return $this->render('reservation/confirmFront.html.twig', [
            'reservation' => $reservation
        ]);
    }
    /**
     * @Route("/frontOffice/add/{id_vol}", name="reservation_add")
     */
    public function indexFront(Request $request,$id_vol,\Swift_Mailer $mailer): Response
    {
        $vol = $this->getDoctrine()
            ->getRepository(Vol::class)
            ->find($id_vol);
        $reservation = new Reservation();
        $reservation->setVol($vol);
        $reservation->setFinalPrice($reservation->getVol()->getInitialPrice());
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if($reservation->getClass() =='Business class' )
            {
                $reservation->setFinalPrice($reservation->getFinalPrice()*2);
            }
            if($reservation->getType() == 'round trip'){
                $reservation->setFinalPrice($reservation->getFinalPrice()*1.5);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($reservation);
            $entityManager->flush();

            $message = (new \Swift_Message('TravelAgency'))
                ->setFrom('amir.daghsen@esprit.tn')
                ->setTo($reservation->getClient()->getEmail())
                ->setBody('Votre reservation a ete effecuée avec succes');
/*https://myaccount.google.com/lesssecureapps?rapt=AEjHL4Mt6N02f6NSgr8P55uc6T3b_Cek2ocSDmCX22MBUo9FD1m1jxapQCdI4nGstdpuJdPZHRm3ScwY9oWwVy7bJfvEJqly4Q*/
            $mailer->send($message);


            return $this->redirectToRoute('confirm_front_reservation', ['reservation_id'=> $reservation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/addFront.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'vol'=>$vol
        ]);
    }
    /**
     * @Route("/admin-reservation/searchResajax ", name="searchResajax")
     */
    public function searchResajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $requestString=$request->get('searchValue');
        $reservations = $repository->findReservationByName($requestString);

        return $this->render('reservation/ajax.html.twig', [
            "reservations"=>$reservations
        ]);
    }

}
