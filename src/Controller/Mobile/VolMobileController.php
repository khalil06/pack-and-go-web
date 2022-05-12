<?php
namespace App\Controller\Mobile;

use App\Entity\Vol;
use App\Repository\VolRepository;
use App\Repository\CompanyRepository;
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
 * @Route("/mobile/vol")
 */
class VolMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(VolRepository $volRepository): Response
    {
        $vols = $volRepository->findAll();

        if ($vols) {
            return new JsonResponse($vols, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/show", methods={"POST"})
     */
    public function show(Request $request, VolRepository $volRepository): Response
    {
        $vol = $volRepository->find((int)$request->get("id"));

        if ($vol) {
            return new JsonResponse($vol, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request, CompanyRepository $companyRepository): JsonResponse
    {
        $vol = new Vol();

        return $this->manage($vol, $companyRepository,  $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, VolRepository $volRepository, CompanyRepository $companyRepository): Response
    {
        $vol = $volRepository->find((int)$request->get("id"));

        if (!$vol) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($vol, $companyRepository, $request, true);
    }

    public function manage($vol, $companyRepository, $request, $isEdit): JsonResponse
    {   
        $company = $companyRepository->find((int)$request->get("company"));
        if (!$company) {
            return new JsonResponse("company with id " . (int)$request->get("company") . " does not exist", 203);
        }
        
        
        $vol->setUp(
            $company,
            $request->get("origin"),
            $request->get("destination"),
            DateTime::createFromFormat("d-m-Y", $request->get("departureDate")),
            DateTime::createFromFormat("d-m-Y", $request->get("arrivalDate")),
            (int)$request->get("status"),
            (int)$request->get("initialPrice")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vol);
        $entityManager->flush();

        return new JsonResponse($vol, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, VolRepository $volRepository): JsonResponse
    {
        $vol = $volRepository->find((int)$request->get("id"));

        if (!$vol) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($vol);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, VolRepository $volRepository): Response
    {
        $vols = $volRepository->findAll();

        foreach ($vols as $vol) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
}
