<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Reservationchambre;
use App\Form\ReservChambreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ReservationChambreController extends AbstractController
{
    /**
     * @Route("listReservChambres", name="listReservChambres")
     */
    public function index(): Response
    {
        $listReservCh = $this->getDoctrine()->getRepository(Reservationchambre::class)->findall();
        return $this->render('reservation_chambre/index.html.twig', ['reservChambre' => $listReservCh]);
    }

    /**
     * @Route("/deleteReservChambre/{id}", name="deleteReservChambre")
     */
    public function deleteReservChambre($id)
    {
        $reservCh = $this->getDoctrine()->getRepository(Reservationchambre::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservCh);
        $em->flush();
        return $this->redirectToRoute('listReservChambres');
    }

    /**
     * @Route("/reserverCh/{id}", name="reserverCh", methods={"GET","POST"})
     * @param Request $request
     * @return Response

     */
    public function reserverChambre(Request $request, MailerInterface  $mailer):Response
    {
        $reservationCh = new Reservationchambre();
        $id= $request->get('id');
        $chambre = $this->getDoctrine()->getRepository(Chambre::class)->find($id);
        $form = $this->createForm(ReservChambreType::class, $reservationCh);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          //  $prixx = $this->getDoctrine()->getRepository(Chambre::class)->Prix();
            $reservationCh->setIdChambre($chambre);
            $reservationCh = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservationCh);
            $em->flush();

            $idChambre = $reservationCh->getIdChambre();
            $query = $em->createQuery(
                'SELECT p, c
                FROM App\Entity\Hotel p
                join p.chambre c
                WHERE c.idChambre = :idChambre
               '
            )
                ->setParameter('idChambre', $idChambre);
            $prix=$query->getResult();

            $checkin = $reservationCh->getCheckIn();
            $checkout = $reservationCh->getCheckOut();
            $id = $reservationCh->getNumReservation();
            $datediff = date_diff($checkout, $checkin);
            $datef = (int)( $datediff->format('%d days'));

            $pdfOptions = new Options();
            $pdfOptions->set('isRemoteEnabled', true);
            $pdfOptions->set('defaultFont', 'Arial');
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            // Retrieve the HTML generated in our twig file
            $html = $this->renderView('mail_hotel/pdfHotel.html.twig', array('check_in' => $checkin,
                'check_out' => $checkout,
                'num_reservation' => $id,
                'chambre' => $chambre,
                'prix' => $prix,
                'datediff' => $datef));
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
            $pdfFilepath = $pdf_directory . '/invoice.pdf';
            // Write file to the desired path
            file_put_contents($pdfFilepath, $output);

            $message = (new Email())
                ->from('packandgomail@gmail.com')
                ->to('dorsaf.charfeddine@esprit.tn')
                ->subject('Booking confirmation')
                ->attachFromPath($pdf_directory . '/invoice.pdf')
                ->html(
                    $this->renderView(
                        'mail_hotel/mail.html.twig',
                        array('check_in' => $checkin,
                            'check_out' => $checkout,
                            'num_reservation' => $id,
                            'chambre' => $chambre,
                            'prix' => $prix,
                            'datediff' => $datef
                        )),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success', 'réservation effectuée avec succes! Merci davoir choisir pack & go');
            return $this->redirectToRoute('listHotelsFront');
        }

            return $this->render('reservation_chambre/reserverChambre.html.twig', [
            'form' => $form -> createView (),
            ]);

    }

    /**
     * @Route("/searchRes", name="searchRes", methods={"GET"})
     */
    public function searchRes(Request $request, NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Reservationchambre::class);
        $requestString = $request->get('searchValue');
        $reserv = $repository->findEntitiesByString($requestString);
        return $this->render("reservation_chambre/tabReserv.html.twig",
            ['reservChambre' => $reserv]);
    }

    /**
     * @Route("/prix", name="prix")
     */
    public function prixSejour(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Reservationchambre::class);
        $requestString = $request->get('searchValue');
        $reserv = $repository->findEntitiesByString($requestString);
        return $this->render("reservation_chambre/tabReserv.html.twig",
            ['reservChambre' => $reserv]);
    }

}
