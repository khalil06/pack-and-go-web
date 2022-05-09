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

class AddInteractionController extends AbstractController
{
    /**
     * @Route("/add/interaction", name="app_add_interaction")
     */
    public function index(Request $request): Response
    {
        $interaction = new InteractionStyle();
        $interactions = $this->getDoctrine()->getRepository(InteractionStyle::class)->findall();
        $form=$this->createFormBuilder($interaction)
            ->add('interactionId', TextType::class)
            ->add('interactionName', TextType::class)
            ->add('interactionDetails', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Interaction Style', 'attr' => ['class' => 'btn btn-primary btn-block bg-teal-600']])
            ->getForm();
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager=$this->getDoctrine()->getManager();
                $manager->persist($interaction);
                $manager->flush();
            }

        return $this->render('add_interaction/index.html.twig', [
            'form'=>$form->createView(),
            'interactions'=>$interactions,
        ]);
    }
}
