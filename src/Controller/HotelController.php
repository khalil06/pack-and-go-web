<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class HotelController extends AbstractController
{
    /**
     * @Route("/back", name="app_hotel")
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
        if($form->isSubmitted()){

         /*   $img = $request->files->get('hotel')['image'];
            $uploads = $this->getParameter('uploads');

        /   $filename = md5(uniqid()) . '.' . $img->guessExtension();
            $img->move(
                $uploads,
                $filename
            );
            $hotel->setImage($filename);
*/
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
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listHotels');
        }
        return $this->render("hotel/updateHotel.html.twig",array('form'=>$form->createView()));
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
        $listHotels = $this->getDoctrine()->getRepository(Hotel::class)->findall();
        return $this->render('hotel/listHotelsFront.html.twig', ['hotels' => $listHotels]);

    }

    /**
     * @Route("/front", name="front")
     */
    public function indexFront(): Response
    {
        $listHotels = $this->getDoctrine()->getRepository(Hotel::class)->findall();
        return $this->render('hotel/listHotelsFront.html.twig', ['hotels' => $listHotels]);
    }

}
