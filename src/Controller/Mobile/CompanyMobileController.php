<?php
namespace App\Controller\Mobile;

use App\Entity\Company;
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
 * @Route("/mobile/company")
 */
class CompanyMobileController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        $companys = $companyRepository->findAll();

        if ($companys) {
            return new JsonResponse($companys, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/show", methods={"POST"})
     */
    public function show(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = $companyRepository->find((int)$request->get("id"));

        if ($company) {
            return new JsonResponse($company, 200);
        } else {
            return new JsonResponse([], 204);
        }
    }

    /**
     * @Route("/add", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $company = new Company();

        return $this->manage($company, $request, false);
    }

    /**
     * @Route("/edit", methods={"POST"})
     */
    public function edit(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = $companyRepository->find((int)$request->get("id"));

        if (!$company) {
            return new JsonResponse(null, 404);
        }

        return $this->manage($company, $request, true);
    }

    public function manage($company, $request, $isEdit): JsonResponse
    {   
        $file = $request->files->get("file");
        if ($file) {
            $imageFileName = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('uploads_directory'), $imageFileName);
            } catch (FileException $e) {
                dd($e);
            }
        } else {
            if ($request->get("image")) {
                $imageFileName = $request->get("image");
            } else {
                $imageFileName = "null";
            }
        }
        
        $company->setUp(
            $request->get("name"),
            $imageFileName,
            $request->get("description")
        );
        
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($company);
        $entityManager->flush();

        return new JsonResponse($company, 200);
    }

    /**
     * @Route("/delete", methods={"POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, CompanyRepository $companyRepository): JsonResponse
    {
        $company = $companyRepository->find((int)$request->get("id"));

        if (!$company) {
            return new JsonResponse(null, 200);
        }

        $entityManager->remove($company);
        $entityManager->flush();

        return new JsonResponse([], 200);
    }

    /**
     * @Route("/deleteAll", methods={"POST"})
     */
    public function deleteAll(EntityManagerInterface $entityManager, CompanyRepository $companyRepository): Response
    {
        $companys = $companyRepository->findAll();

        foreach ($companys as $company) {
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return new JsonResponse([], 200);
    }
    
    /**
     * @Route("/image/{image}", methods={"GET"})
     */
    public function getPicture(Request $request): BinaryFileResponse
    {
        return new BinaryFileResponse(
            $this->getParameter('uploads_directory') . "/" . $request->get("image")
        );
    }
    
}
