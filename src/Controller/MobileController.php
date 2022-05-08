<?php

namespace App\Controller;

use App\Entity\Personality;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobile", name="app_mobile")
     */
    public function index(): Response

    {
        $evenements = $this->getDoctrine()
            ->getRepository(Personality::class)
            ->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = [$normalizer];
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($evenements);
        return new JsonResponse($formatted);
    }
    // {
    //     return $this->render('mobile/index.html.twig', [
    //         'controller_name' => 'MobileController',
    //     ]);
    // }
}
