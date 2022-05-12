<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Personality;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ActiviteMobille  extends AbstractController
{
    /**
     * @Route("/addActivite", name="addActivite")
     */
    public function addActivite(Request $request, SerializerInterface $serializer): Response
    {

        $activite = new Activite();
        $em = $this->getDoctrine()->getManager();
        $nomActivite = $request->query->get("nomActivite");
        $typeActivite = $request->query->get("typeActivite");
        $prix = $request->query->get("prix");
        $adresse = $request->query->get("adresse");
        $pays = $request->query->get("pays");
        $activite->setNomActivite((string)$nomActivite);
        $activite->setTypeActivite((string)$typeActivite);
        $activite->setPrix((float)$prix);
        $activite->setAdresse((string)$adresse);
        $activite->setPays((string)$pays);



        //$content=$request->getContent();
        //  $activite=$serializerInterface->deserialize($content,Activite::class,'json');
        $jsonContent = $data = $serializer->serialize($activite, 'json');

        $em->persist($activite);
        $em->flush();

        return new Response($jsonContent);
    }
    /**
     * @Route("/index", name="app_user_indexMobile", methods={"GET"})
     */
    public function indexMobile(NormalizerInterface $normalizer, Request $request, PaginatorInterface $paginator): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Activite::class)
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
        // $collection = $this->getDoctrine()
        //     ->getRepository(Activite::class)
        //     ->findAll();
        // $activites = array_reverse($collection);

        // $jsonContent= $normalizer->normalize($activites, 'json', ['groups'=>'productsgroup']);

        // return  new Response(json_encode($jsonContent));
    }
}
