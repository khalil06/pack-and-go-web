<?php

namespace App\Controller;

use App\Entity\UserPersonality;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MobileUPController extends AbstractController
{
    /**
     * @Route("/mobile/u/p", name="app_mobile_u_p")
     */
    public function index(): Response

    {
        $personalities = $this->getDoctrine()
            ->getRepository(UserPersonality::class)
            ->findAll();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = [$normalizer];
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($personalities);
        return new JsonResponse($formatted);
    }
}
