<?php

namespace App\Controller;

use App\Entity\Personality;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalityDashboardController extends AbstractController
{
    /**
     * @Route("/personality/dashboard/{id}", name="app_personality_dashboard")
     */
    public function index(string $id,Personality $personality): Response
    {
        $personalities = $this->getDoctrine()->getRepository(Personality::class)->findall();
        $form = $this->createFormBuilder($personality)
            ->add('personalityId', TextType::class)
            ->add('social', TextType::class)
            ->add('interaction', TextType::class)
            ->add('processing', TextType::class)
            ->add('decisionMaking', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Personality', 'attr' => ['class' => 'btn btn-primary btn-block bg-teal-600']])
            ->getForm();
        

        return $this->render('personality_dashboard/index.html.twig', [
            'personalities' => $personalities,
            'form' => $form->createView(),
        ]);
    }
}
