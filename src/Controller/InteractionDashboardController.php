<?php

namespace App\Controller;

use App\Entity\InteractionStyle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InteractionDashboardController extends AbstractController
{
    /**
     * @Route("/interaction/dashboard/{id}", name="app_interaction_dashboard")
     */
    public function index(string $id,Request $request): Response
    {
        $interactionStyle=$this->getDoctrine()->getRepository(InteractionStyle::class)->find($id);
        $interactionStyles = $this->getDoctrine()->getRepository(InteractionStyle::class)->findall();
        $form=$this->createFormBuilder($interactionStyle)
            ->add('interactionId', TextType::class)
            ->add('interactionName', TextType::class)
            ->add('interactionDetails', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Interaction Style', 'attr' => ['class' => 'btn btn-primary btn-block bg-teal-600']])
            ->getForm();
            $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            # code...
            $manager = $this->getDoctrine()->getManager();
            try {
                if ( !$this->getDoctrine()->getRepository(InteractionStyle::class)->find($interactionStyle->getInteractionId())) {
                    $manager->persist($interactionStyle);
                    $manager->flush();
                } else {
                    $manager->flush();
                };

            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
            return $this->redirectToRoute('app_dashboard_table');
        }
        return $this->render('interaction_dashboard/index.html.twig', [
            'form'=>$form->createView(),
            'interactionStyles'=>$interactionStyles,
        ]);
        // return $this->render('interaction_dashboard/index.html.twig', [
        //     'controller_name' => 'InteractionDashboardController',
        // ]);
    }
}
