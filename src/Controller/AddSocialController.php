<?php

namespace App\Controller;

use App\Entity\SocialStyle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddSocialController extends AbstractController
{
    /**
     * @Route("/add/social", name="app_add_social")
     */
    public function index(Request $request): Response
    {
        $socialStyle = new SocialStyle();
        $socialStyle->setSocialId('x');
        $socialStyles = $this->getDoctrine()->getRepository(SocialStyle::class)->findall();
    
        $form=$this->createFormBuilder($socialStyle)
            ->add('socialId', TextType::class)
            ->add('socialName', TextType::class)
            ->add('socialDetails', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Social Style', 'attr' => ['class' => 'btn btn-primary btn-block bg-teal-600']])
            ->getForm();
        
            $form->handleRequest($request);
            
 
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($socialStyle);
                $manager->flush();
                return $this->redirectToRoute('app_gestion_personnalite');
            }
            
        return $this->render('add_social/index.html.twig', [
           'form'=>$form->createView(),
              'socialStyles'=>$socialStyles,
        ]);
    }
}
