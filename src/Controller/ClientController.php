<?php

namespace App\Controller;

<<<<<<< HEAD
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
=======
use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
>>>>>>> amir
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

<<<<<<< HEAD
class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="app_client")
     */
    public function index(): Response
    {

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
=======
/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
>>>>>>> amir
        ]);
    }

    /**
<<<<<<< HEAD
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


        return $this->redirectToRoute('app_client_table2');
    }
    /**
     * @Route("/client/table", name="app_client_table2")
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

        return $this->render('client/index.html.twig', [

            'activites'=>$activites,

        ]);

=======
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
>>>>>>> amir
    }
}
