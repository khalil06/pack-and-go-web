<?php

namespace App\Controller;

use App\Entity\Personality;
use App\Entity\UserPersonality;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YourPersonalityController extends AbstractController
{
    /**
     * @Route("/your/personality", name="app_your_personality")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
                // look for a single Product by name
                // $repository = $this->getDoctrine()->getRepository(Personality::class);
                // $personality = $repository->findOneBy(['personalityId' => $answer]);
        
                //adding userpersonatliy
    
                $repository = $doctrine->getRepository(UserPersonality::class);
                $repositoryPersonality = $doctrine->getRepository(Personality::class);

     
                
                // look for a single person$personality by name
                $personalityUser = $repository->findOneBy(['userId' => 1]);
                $personality = $repositoryPersonality->findOneBy(['personalityId' => $personalityUser->getPersonalityId()]);

        return $this->render('your_personality/index.html.twig', [
            'controller_name' => 'YourPersonalityController',
            'personality' => $personality,
        ]);
    }
}
