<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\ActiviteType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientActiviteController extends AbstractController
{
    /**
     * @Route("/client", name="app_client")
     */
    public function index(): Response
    {

        return $this->render('client_activite/index.html.twig', [

            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/reserverActivite/{id}", name="reserverActivite")
     */
    public function reserverActivite(Request $request,$id):Response
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find(10);
        $activite = $this->getDoctrine()->getRepository(Activite ::class)->find($id);
        $ticket= new Ticket();

        $ticket ->setIdUser($user);
        $ticket->setIdActivite($activite);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf_activite/pdfActivite.html.twig', array('numTicket' => $ticket->getNumTicket(),
            'adresse' => $activite->getAdresse(),
            'prix' => $activite->getPrix(),
            'typeActivite' => $activite->getTypeActivite(),
            'nomActivite' => $activite->getNomActivite(),
            'nom'=>$user->getLastName(),
            'prenom'=>$user->getFirstName(),
            'pays'=>$activite->getPays()
            ));
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $output = $dompdf->output();
        $pdf_directory = $this->getParameter('pdf');
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath = $pdf_directory."/ticket".$user->getLastName()." ".$user->getFirstName()." ".$ticket->getNumTicket().".pdf";
        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);


        return $this->redirectToRoute('app_client_table2');
    }
    /**
     * @Route("/clientactivite/table", name="app_client_table2")
     */
    public function createActivite(Request $request,PaginatorInterface $paginator)
    {


        $query = $this->getDoctrine()->getRepository(Activite ::class)->findAll();
        $activites = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        $activite = new Activite();

        $form = $this->createFormBuilder($activite)


           // ->add("save",SubmitType::class,["label"=>"Réserver"])

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($activite);
            $manager->flush();



        }

        return $this->render('client_activite/index.html.twig', [

            'activites'=>$activites,

        ]);

    }
}
