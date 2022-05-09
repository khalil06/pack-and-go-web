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

class SocialDashboardController extends AbstractController
{
    /**
     * @Route("/social/dashboard/{id}", name="app_social_dashboard")
     */
    public function index(string $id,Request $request): Response
    {

        $socialStyle=$this->getDoctrine()->getRepository(SocialStyle::class)->find($id);
        $socialStyles = $this->getDoctrine()->getRepository(SocialStyle::class)->findall();
    
        $form=$this->createFormBuilder($socialStyle)
            ->add('socialId', TextType::class)
            ->add('socialName', TextType::class)
            ->add('socialDetails', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Social Style', 'attr' => ['class' => 'btn btn-primary btn-block bg-teal-600']])
            ->getForm();
           try {
            $form->handleRequest($request);
           } catch (\Throwable $th) {
               //throw $th;
           }
            if ($form->isSubmitted() && $form->isValid()) {
                # code...
                $manager = $this->getDoctrine()->getManager();
                try {
                    if ( !$this->getDoctrine()->getRepository(SocialStyle::class)->find($socialStyle->getSocialId())) {
                        $manager->persist($socialStyle);
                        $manager->flush();
                    } else {
                        $manager->flush();
        
                    };
                   
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
                return $this->redirectToRoute('app_dashboard_table');
            }
            
        return $this->render('social_dashboard/index.html.twig', [
           'form'=>$form->createView(),
              'socialStyles'=>$socialStyles,
        ]);
    }


}
