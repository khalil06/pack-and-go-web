<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Form\EditVolType;
use App\Form\VolType;
use App\Repository\VolRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vol")
 */
class VolController extends AbstractController
{
    /**
     * @Route("/", name="vol_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator,VolRepository $volRepository): Response
    {
        $donnes=$volRepository->findAll();
        $vols=$paginator->paginate(
            $donnes,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('vol/index.html.twig', [
            'vols' => $vols
        ]);
    }

    /**
     * @Route("/new", name="vol_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vol = new Vol();

        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $vol->setStatus(false);
            $entityManager->persist($vol);
            $entityManager->flush();

            return $this->redirectToRoute('vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/new.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vol_show", methods={"GET"})
     */
    public function show(Vol $vol): Response
    {
        return $this->render('vol/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vol_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vol $vol): Response
    {
        $form = $this->createForm(EditVolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/edit.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vol_delete", methods={"POST"})
     */
    public function delete(Request $request, Vol $vol): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vol_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/frontOffice/flights", name="vol_index_front", methods={"GET"})
     */
    public function indexFront(VolRepository $volRepository): Response
    {
        return $this->render('vol/indexFront.html.twig', [
            'vols' => $volRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin-vol/searchVolajax ", name="searchVolajax")
     */
    public function searchVolajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Vol::class);
        $requestString=$request->get('searchValue');
        $vols = $repository->findReservationByDestination($requestString);

        return $this->render('vol/ajax.html.twig', [
            'vols'=>$vols
        ]);
    }


}
