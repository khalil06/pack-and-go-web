<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Hotel;
use App\Form\ChambreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ChambreController extends AbstractController
{
    /**
     * @Route("/listChambres", name="listChambres")
     */
    public function index(): Response
    {
        $listChambres = $this->getDoctrine()->getRepository(Chambre::class)->findall();
        return $this->render('chambre/index.html.twig', ['chambres' => $listChambres]);
    }

    /**
     * @Route("/addChambre", name="addChambre")
     * @param Request $request
     * @return Response
     */
    public function addChambre(Request $request):Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('image')->getData();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $chambre->setImage($filename);
            try{
                $file->move(
                    $this->getParameter('uploads'),
                    $filename
                );
            } catch(FileException $e){

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($chambre);
            $em->flush();
            return $this->redirectToRoute('listChambres');
        }
        return $this->render("chambre/addChambre.html.twig",['chambre' => $chambre,
            'form'=>$form->createView()]);
    }

    /**
     * @Route("/updateChambre/{id}", name="updateChambre")
     */
    public function updateChambre(Request $request,$id):Response
    {
        $chambre = $this->getDoctrine()->getRepository(Chambre::class)->find($id);
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('image')->getData();
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $chambre->setImage($filename);
                try {
                    $file->move(
                        $this->getParameter('uploads'),
                        $filename
                    );
                } catch (FileException $e) {

                }

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listChambres');
        }
        return $this->render("chambre/updateChambre.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/deleteChambre/{id}", name="deleteChambre")
     */
    public function deleteChambre($id)
    {
        $chambre = $this->getDoctrine()->getRepository(Chambre::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($chambre);
        $em->flush();
        return $this->redirectToRoute('listChambres');
    }

    /**
     * @Route("/chambres", name="chambres")
     */
    public function indexFront(): Response
    {
        $listHotels = $this->getDoctrine()->getRepository(Chambre::class)->findall();
        return $this->render('chambre/listChambresFront.html.twig', ['hotels' => $listHotels]);
    }

    /**
     * @Route("/chambres/{id}", name="chambresById")
     */
    public function AfficherChambresById($id)
    {
        $hotel = $this->getDoctrine()->getRepository(Hotel::class)->find($id);
        $chambre= $this->getDoctrine()->getRepository(Chambre::class)->listChambresById($hotel->getIdHotel());
        return $this->render('chambre/listChambresFront.html.twig', [
            "hotel" => $hotel,
            "chambres"=>$chambre]);
    }

    /**
     * @Route("/searchCh", name="searchCh", methods={"GET"})
     */
    public function searchCh(Request $request, NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Chambre::class);
        $requestString = $request->get('searchValue');
        $chambres = $repository->findEntitiesByString($requestString);
        return $this->render("chambre/tabChambre.html.twig",
            ['chambres' => $chambres]);
    }

}
