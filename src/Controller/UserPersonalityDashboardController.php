<?php

namespace App\Controller;

use App\Entity\UserPersonality;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPersonalityDashboardController extends AbstractController
{
    /**
     * @Route("/user/personality/dashboard/{id}", name="app_user_personality_dashboard",methods={"GET","HEAD"})
     */
    public function index(string $id,Request $request,UserPersonality $us): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $deleteUserPersonality = $manager->getRepository(UserPersonality::class)->findOneBy(['userPersonalityId'=>$id]);
        $manager->remove($deleteUserPersonality);
        $manager->flush();
        return $this->redirectToRoute('app_dashboard_table');
 
        $userPersonality = new UserPersonality();
        $userPersonalities = $this->getDoctrine()->getRepository(UserPersonality::class)->findall();
        $userPersonality = $this->getDoctrine()->getRepository(UserPersonality::class)->findOneBy(['userId' => $id]);
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
        return $this->render('user_personality_dashboard/index.html.twig', [
            'formUserPersonality' => $form->createView(),
            'userPersonalities' => $userPersonalities,
        ]);
    }
}
