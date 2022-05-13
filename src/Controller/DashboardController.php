<?php

namespace App\Controller;

use App\Entity\DecisionMakingStyle;
use App\Entity\InteractionStyle;
use App\Entity\Personality;
use App\Entity\ProcessingStyle;
use App\Entity\SocialStyle;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserPersonality;
use App\Entity\Activite;
use App\Entity\Ticket;
use App\Form\ActiviteType;

use PhpParser\Node\Stmt\Label;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard()
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    /**
     * @Route("/dashboard/table", name="app_dashboard_tablee")
     */
    public function createUserPersonality(Request $request)
    {

        $userPersonality = new UserPersonality();
        // $userPersonality->setPersonalityId('INTP');
        // $userPersonality->setUserId("5");
        $personalities = $this->getDoctrine()->getRepository(Personality::class)->findall();
        $socialStyles = $this->getDoctrine()->getRepository(SocialStyle::class)->findall();
        $interactionStyles = $this->getDoctrine()->getRepository(InteractionStyle::class)->findall();
        $processingStyles = $this->getDoctrine()->getRepository(ProcessingStyle::class)->findall();
        $decisionMakingStyles = $this->getDoctrine()->getRepository(DecisionMakingStyle::class)->findall();
        $userPersonalities = $this->getDoctrine()->getRepository(UserPersonality::class)->findall();
        $form = $this->createFormBuilder($userPersonality)
            ->add('personalityId', TextType::class)
            ->add('userId', NumberType::class)
            // ->add("save",SubmitType::class,["label"=>"enregistrer"])
            // ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            # code...
            $manager = $this->getDoctrine()->getManager();
            if (!$productExist = $this->getDoctrine()->getRepository(UserPersonality::class)->findOneBy(['userId' => $userPersonality->getUserId()])) {
                $manager->persist($userPersonality);
                $manager->flush();
            } else {
                $manager->remove($productExist);
                $manager->flush();
                $manager->persist($userPersonality);
                $manager->flush();
            };
        }
        return $this->render('dashboard/table-basic.html.twig', [
            'formUserPersonality' => $form->createView(),
            'personalities' => $personalities,
            'socialStyles' => $socialStyles,
            'decisionMakingStyles' => $decisionMakingStyles,
            'interactionStyles' => $interactionStyles,
            'processingStyles' => $processingStyles,
            'userPersonalities' => $userPersonalities,
        ]);
    }

    /**
     * @Route("/deleteActivite/{id}", name="deleteActivite")
     */
    public function deleteActivite($id)
    {
        $activite = $this->getDoctrine()->getRepository(Activite::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($activite);
        $em->flush();
        return $this->redirectToRoute('app_dashboard_table');
    }
    /**
     * @Route("/updateActivite/{id}", name="updateActivite")
     */
    public function updateActivite(Request $request, $id): Response
    {
        $activite = $this->getDoctrine()->getRepository(Activite::class)->find($id);
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_dashboard_table');
        }
        return $this->render("dashboard/updateActivite.html.twig", array('formUpdateActivite' => $form->createView()));
    }
    /**
     * @Route("/reserverActivitee", name="reserverActivitee")
     */
    public function reserverActivite(Request $request)
    {
        $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findall();
        return $this->render('reservationA/table-activite.html.twig', [
            'tickets' => $tickets,


        ]);
    }
    /**
     * @Route("/dashboard/tableactivite", name="app_dashboard_table")
     */
    public function createActivite(Request $request)
    {

        $activites = $this->getDoctrine()->getRepository(Activite::class)->findall();
        $activite = new Activite();

        $form = $this->createFormBuilder($activite)
            ->add('nomActivite', TextType::class)
            ->add('typeActivite', TextType::class)
            ->add('prix', NumberType::class)
            ->add('adresse', TextType::class)
            ->add('pays', TextType::class)
            ->add('imagePath', FileType::class)

            ->add("save", SubmitType::class, ["label" => "Enregistrer"])

            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imagePath')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $activite->setImagePath($filename);
            try {
                $file->move(
                    $this->getParameter('uploads'),
                    $filename
                );
            } catch (FileException $e) {
            }

            # code...
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($activite);
            $manager->flush();
        }
        $cinema = $this->getDoctrine()->getRepository(Activite::class)->createQueryBuilder('u')
            ->select('count(u.idActivite)')
            ->where('u.typeActivite = :c')
            ->setParameter('c', "cinéma")
            ->getQuery()
            ->getSingleScalarResult();


        $musée = $this->getDoctrine()->getRepository(Activite::class)->createQueryBuilder('u')
            ->select('count(u.idActivite)')
            ->where('u.typeActivite = :c')
            ->setParameter('c', "musée")
            ->getQuery()
            ->getSingleScalarResult();


        $plage = $this->getDoctrine()->getRepository(Activite::class)->createQueryBuilder('u')
            ->select('count(u.idActivite)')
            ->where('u.typeActivite = :c')
            ->setParameter('c', "plage")
            ->getQuery()
            ->getSingleScalarResult();

        $espace = $this->getDoctrine()->getRepository(Activite::class)->createQueryBuilder('u')
            ->select('count(u.idActivite)')
            ->where('u.typeActivite = :c')
            ->setParameter('c', "Espace vert")
            ->getQuery()
            ->getSingleScalarResult();

        $table = [$cinema, $musée, $plage, $espace, 0];
        return $this->render('dashboard/table-activite.html.twig', [
            'formActivite' => $form->createView(),
            'activites' => $activites,

            'table' => json_encode($table),

        ]);
    }
}
