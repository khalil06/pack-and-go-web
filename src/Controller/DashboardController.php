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
use PhpParser\Node\Stmt\Label;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;



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
// =======
//         return $this->render('admin/index.html.twig');
//     }

//     /**
//      * @Route("/front", name="app_front")
//      */
//     public function front()
//     {
//         return $this->render('baseFront.html.twig');
// >>>>>>> User
    }
    /**
     * @Route("/dashboard/table", name="app_dashboard_table")
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


}

// class UserPersonalityController extends AbstractController
// {

//     public function new(Request $request): Response
//     {
//         // creates a task object and initializes some data for this example
//         $userPersonality = new UserPersonality();
//         $userPersonality->setPersonalityId('INTP');
//         $userPersonality->setUserId("5");

//         $form = $this->createFormBuilder($userPersonality)
//             ->add('personalityId', TextType::class)
//             ->add('userId', TextType::class)
//             // ->add('save', SubmitType::class, ['label' => 'Create Task'])
//             ->getForm();

//             return $this->render('dashboard/table-basic.html.twig', [
//                 'formUserPersonality' => $form->createView(),
//             ]);
//         // ...
//     }
// }