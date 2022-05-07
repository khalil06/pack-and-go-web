<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class HotelController extends AbstractController
{
    /**
     * @Route("/back", name="back")
     */
    public function index(): Response
    {
        $listHotels = $this->getDoctrine()->getRepository(Hotel::class)->findall();
        return $this->render('hotel/index.html.twig', ['hotels' => $listHotels]);
    }

    /**
     * @Route("/addHotel", name="addHotel")
     * @param Request $request
     * @return Response
     */
    public function addHotel(Request $request):Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('image')->getData();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $hotel->setImage($filename);
            try{
                $file->move(
                    $this->getParameter('uploads'),
                    $filename
                );
            } catch(FileException $e){
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('listHotels');
        }
        return $this->render("hotel/addHotel.html.twig",['hotel' => $hotel,
            'form'=>$form->createView()]);
    }


    /**
     * @Route ("/listHotels",name="listHotels")
     *
     */
    public function afficherHotels()
    {
        $listHotels = $this->getDoctrine()->getRepository(Hotel::class)->findall();
        return $this->render('hotel/index.html.twig', ['hotels' => $listHotels]);
    }

    /**
     * @Route("/updateHotel/{id}", name="updateHotel")
     */
    public function updateHotel(Request $request,$id):Response
    {
        $hotel = $this->getDoctrine()->getRepository(Hotel::class)->find($id);
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        $image = $form->get('image')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('image')->getData() != null) {
                $file = $form->get('image')->getData();
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $hotel->setImage($filename);
                try {
                    $file->move(
                        $this->getParameter('uploads'),
                        $filename
                    );
                } catch (FileException $e) {

                }
            }else{
                $hotel->setImage($image);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listHotels');
        }
        return $this->render("hotel/updateHotel.html.twig",array('form'=>$form->createView(), 'image' => $image));
    }

    /**
     * @Route("/deleteHotel/{id}", name="deleteHotel")
     */
    public function deleteHotel($id)
    {
        $hotel = $this->getDoctrine()->getRepository(Hotel::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute("listHotels");
    }


    /**
     * @Route ("/listHotelsFront",name="listHotelsFront")
     *
     */
    public function afficherHotelsFront()
    {
        $listHotels = $this->getDoctrine()->getRepository(Hotel::class)->findAll();
        return $this->render('hotel/listHotelsFront.html.twig', ['hotels' => $listHotels]);

    }


    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    public function search(Request $request, NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Hotel::class);
        $requestString = $request->get('searchValue');
        $hotels = $repository->findEntitiesByString($requestString);
        return $this->render("hotel/tabHotel.html.twig",
            ['hotels' => $hotels]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }


    /**
     * @Route("/front", name="front")
     */
    public function indexFront(SerializerInterface $serializerInterface)
    {
        $listHotels = $this->getDoctrine()->getRepository(Hotel::class)->findAll();
        $json = $serializerInterface->serialize($listHotels, 'json', ['groups' => 'hotels']);
        return new Response($json);
    }


    /**
     * @Route("/addHotell", name="addHotell")
     */
    public function addHotell(Request $request, SerializerInterface $serializer)
    {
        $hotel = new Hotel();
        $em = $this->getDoctrine()->getManager();
        $nom = $request->query->get("nomHotel");
        $et = $request->query->get("nbrEtoiles");
        $ch = $request->query->get("nbrChambres");
        $ad = $request->query->get("adresse");
        $pays = $request->query->get("pays");
        $tel = $request->query->get("tel");
        $email = $request->query->get("email");
        $image = $request->query->get("image");
        $hotel->setNomHotel($nom);
        $hotel->setNbrEtoiles($et);
        $hotel->setNbrChambres($ch);
        $hotel->setAdresse($ad);
        $hotel->setPays($pays);
        $hotel->setTel($tel);
        $hotel->setEmail($email);
        $hotel->setImage($image);
        $data = $serializer->serialize($hotel,'json');
        $em->persist($hotel);
        $em->flush();
        return new Response($data);
    }

    /**
     * @Route("/deleteHotell", name="deleteHotell")
     */
    public function deleteHotell(Request $request, SerializerInterface $serializer)
    {
        $id = $request->get('idHotel');
        $hotel = $this->getDoctrine()->getRepository(Hotel::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $data = $serializer->serialize($hotel,'json', ['groups' =>'hotels'] );
        $em->remove($hotel);
        $em->flush();
        return new Response("deleted successfully");
    }

    /**
     * @Route("/updateHotell", name="updateHotell")
     */
    public function updateHotell(Request $request, SerializerInterface $serializer)
    {
        $hotel = $this->getDoctrine()->getRepository(Hotel::class)->find($request->get('idHotel'));
        $em = $this->getDoctrine()->getManager();
        $hotel->setNomHotel($request->get('nomHotel'));
        $hotel->setNbrEtoiles($request->get("nbrEtoiles"));
        $hotel->setNbrChambres($request->get('nbrChambres'));
        $hotel->setAdresse($request->get('adresse'));
        $hotel->setPays($request->get('pays'));
        $hotel->setTel($request->get('tel'));
        $hotel->setEmail($request->get('email'));
        $hotel->setImage($request->get('image'));
        $em->persist($hotel);
        $em->flush();
        $json = $serializer->serialize($hotel, 'json');
        return new Response($json);
    }

}
