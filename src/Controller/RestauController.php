<?php

namespace App\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Resteau;
use App\services\QrcodeService;
use App\Form\RestauFormType;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Form\RestauUpdateForm;
use App\Repository\RestauRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class RestauController extends AbstractController
{
    /**
     * @Route("/restau", name="app_restau")
     */
    public function index(): Response
    {
        return $this->render('restau/index.html.twig', [
            'controller_name' => 'RestauController',
        ]);
    }
    /**
     * @Route ("/AddR",name="Ajoutrest")
     * @param Request $request
     * @param QrcodeService $qrcodeService
     * @return Response
     */
    public function ajouterRestau(Request $request,QrcodeService $qrcodeService):Response
    {
        $Resteau = new Resteau();
        $form = $this->createForm(RestauFormType::class, $Resteau);
        $form->handleRequest($request);
        $qrCode="";

        if ($form->isSubmitted() &&$form->isValid()) {
            $file = $form->get('imgr')->getData();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $Resteau->setImgr($filename);

            try{
                $file->move(
                    $this->getParameter('uploads'),
                    $filename
                );
            } catch(FileException $e){
            }

            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $qrCode= $qrcodeService->qrcode($data->getNomr());
            $em->persist($Resteau);
            $em->flush();
         return $this->redirectToRoute('affiche');
        }
        return $this->render("restau/index.html.twig", ['Resteau'=> $Resteau,
            'form' => $form->createView(),'qrCode'=>$qrCode]);

    }


    /**
     * @Route ("/afficheR",name="affiche")
     *
     */

    function affichageRestau(Request  $request, PaginatorInterface $paginator)
    {

        $qrCode="";
        $donnees = $this->getDoctrine()->getRepository(Resteau::class)->findall();
        $liste=$paginator->paginate(
            $donnees, //on passe les donnees
            $request->query->getInt('page',1),// num de la page en cours,1 par defaut
            4

        );

       // $liste = $this->getDoctrine()->getRepository(Resteau::class)->findall();

        return $this->render('restau/affichageRestau.html.twig',['tabResteau' => $liste]);


    }

    /**
     * @return Response
     * @Route ("/deleteR/{idr}",name="supp")
     */
    public function deleteRestau($idr)
    {
        {
            $objsupp=$this->getDoctrine()->getRepository(Resteau::class)->find($idr);
            $em=$this->getDoctrine()->getManager();
            $em->remove($objsupp);
            $em->flush();

            return $this->redirectToRoute('affiche');
        }
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateR/{idr}",name="update")
     */
    public function updateRestau(Request $request,$idr)
    {
        $Resteau=$this->getDoctrine()->getRepository(Resteau::class)->find($idr);

        $form = $this->createForm(RestauFormType::class, $Resteau);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&$form->isValid() ) {
            $file = $form->get('imgr')->getData();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $Resteau->setImgr($filename);
            try{
                $file->move(
                    $this->getParameter('uploads'),
                    $filename
                );
            } catch(FileException $e){
            }

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('affiche');
        }
        return $this->render("restau/updaterestau.html.twig", [
            'form' => $form->createView()
        ]);    }
    /**

     * @Route ("/affRF",name="afficheF")
     *
     */
    public function affR()
    {

        $liste = $this->getDoctrine()->getRepository(Resteau::class)->findall();

        return $this->render('restau/affichageRestauFront.html.twig', ['tabResteau' => $liste]);


    }
    /**

     * @Route ("/Homee",name="homee")
     *
     */
    public function  Home()
{
                    //  $liste = $this->getDoctrine()->getRepository(Resteau::class)->findall();

                return $this->render('restau/HomeFront.html.twig');


}


    /**
     * @Route("/searchr", name="searchr", methods={"GET"})
     */
    public function search(Request $request, NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Resteau::class);
        $requestString = $request->get('searchValue');
        $liste = $repository->findBynomr($requestString);
        return $this->render('restau/affichageRestau.html.twig',['tabResteau' => $liste]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/pdf",name="pdf")
     */

    public function makepdf()
    {
        $pdfOptions = new Options();
        $Resteau=new \App\Entity\Resteau();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf();
        $liste2 = $this->getDoctrine()->getRepository(\App\Entity\Resteau::class)->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('restau/pdf.html.twig',['tab'=>$liste2]
        );

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        return $this->redirectToRoute("affiche");




    }

    /**
     * @Route ("/test",name="tetttt")
     */
    public function  getRestau( SerializerInterface  $serializerInterface){

        $Resteau = $this->getDoctrine()->getRepository(Resteau::class)->findall();

        $json=$serializerInterface->serialize($Resteau,'json',['groups'=>'Resteau']);
        return new Response($json);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/addRestau",name="addRestau")
     */
    public function  addR(Request $request,SerializerInterface $serializer)
    {
        $Resteau = new Resteau();
        $em = $this->getDoctrine()->getManager();
        $nomr = $request->query->get("nomr");
        $adressr = $request->query->get("adressr");
        $typer = $request->query->get("typer");
        $paysr = $request->query->get("paysr");
        $telr = $request->query->get("telr");
        $imgr = $request->query->get("imgr");
        $Resteau->setNomr($nomr);
        $Resteau->setAdressr($adressr);
        $Resteau->setTyper($typer);
        $Resteau->setPaysr($paysr);
        $Resteau->setTelr($telr);
        $Resteau->setImgr($imgr);
        $data = $serializer->serialize($Resteau, 'json');
        $em->persist($Resteau);
        $em->flush();
        return new Response($data);

    }
    /**
     * @Route ("/updateResteau",name="updateResteau")
     */
    public function  updateResteau(Request $request,SerializerInterface $serializer)
    {
        $Resteau=$this->getDoctrine()->getRepository(Resteau::class)->find($request->get('idr'));
        $em = $this->getDoctrine()->getManager();

        $Resteau->setNomr($request->get('nomr'));
        $Resteau->setAdressr($request->get('adressr'));
        $Resteau->setTyper($request->get('typer'));
        $Resteau->setPaysr($request->get('paysr'));
        $Resteau->setTelr($request->get('telr'));
        $Resteau->setImgr($request->get('imgr'));
        $em->persist($Resteau);
        $em->flush();
        $json = $serializer->serialize($Resteau, 'json');
        return new Response($json);

    }
    /**
     * @Route ("/deleteRestau",name="deleteRestau")
     */
    public function deleteRestauu(Request $request,SerializerInterface $serializer){
        $idr = $request->get('idr');
        $Resteau=$this->getDoctrine()->getRepository(Resteau::class)->find($idr);
        $em=$this->getDoctrine()->getManager();
        $data = $serializer->serialize($Resteau,'json',['groups'=>'Resteau']);
        $em->remove($Resteau);
        $em->flush();
        return new Response("tfasakh");
    }
}