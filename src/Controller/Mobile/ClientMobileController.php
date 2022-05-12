<?php
namespace App\Controller\Mobile;

use App\Entity\Client;
use App\Repository\ClientRepository;
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
 * @Route("/mobile/client")
 */
class ClientMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();

        if ($clients) {
            return new JsonResponse($clients, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/show", methods={"POST"})
     */
    public function show(Request $request, ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find((int)$request->get("id"));

        if ($client) {
            return new JsonResponse($client, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $client = new Client();

        return $this->manage($client, $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find((int)$request->get("id"));

        if (!$client) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($client, $request, true);
    }

    public function manage($client, $request, $isEdit): JsonResponse
    {   
        
        $client->setUp(
            $request->get("name"),
            $request->get("email")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();

        return new JsonResponse($client, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository): JsonResponse
    {
        $client = $clientRepository->find((int)$request->get("id"));

        if (!$client) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($client);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();

        foreach ($clients as $client) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
}
