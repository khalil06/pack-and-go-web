<?php
namespace App\Controller\Mobile;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Repository\ClientRepository;
use App\Repository\VolRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mobile/reservation")
 */
class ReservationMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        if ($reservations) {
            return new JsonResponse($reservations, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/show", methods={"POST"})
     */
    public function show(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->find((int)$request->get("id"));

        if ($reservation) {
            return new JsonResponse($reservation, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, ClientRepository $clientRepository, VolRepository $volRepository): JsonResponse
    {
        $reservation = new Reservation();

        return $this->manage($reservation, $clientRepository,  $volRepository,  $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, ReservationRepository $reservationRepository, ClientRepository $clientRepository, VolRepository $volRepository): Response
    {
        $reservation = $reservationRepository->find((int)$request->get("id"));

        if (!$reservation) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($reservation, $clientRepository, $volRepository, $request, true);
    }

    public function manage($reservation, $clientRepository, $volRepository, $request, $isEdit): JsonResponse
    {   
        $client = $clientRepository->find((int)$request->get("client"));
        if (!$client) {
            return new JsonResponse("client with id " . (int)$request->get("client") . " does not exist", 203);
        }
        
        $vol = $volRepository->find((int)$request->get("vol"));
        if (!$vol) {
            return new JsonResponse("vol with id " . (int)$request->get("vol") . " does not exist", 203);
        }
        
        
        $reservation->setUp(
            $client,
            $vol,
            $request->get("type"),
            $request->get("classe"),
            (int)$request->get("finalPrice")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse($reservation, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): JsonResponse
    {
        $reservation = $reservationRepository->find((int)$request->get("id"));

        if (!$reservation) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        foreach ($reservations as $reservation) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
}
