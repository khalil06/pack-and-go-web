<?php

namespace App\Controller;

use App\Entity\DecisionMakingStyle;
use App\Entity\InteractionStyle;
use App\Entity\Personality;
use App\Entity\ProcessingStyle;
use App\Entity\SocialStyle;
use App\Entity\UserPersonality;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class GestionPersonnaliteController extends AbstractController
{
    /**
     * @Route("/gestion/personnalite", name="app_gestion_personnalite")
     */
    public function index(Request $request)
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
        return $this->render('gestion_personnalite/index.html.twig', [
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
     * @Route("/gestion/personnalite/delete/{id}", name="app_gestion_personnalite_delete")
     */
    public function delete(string $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $userPersonality = $this->getDoctrine()->getRepository(UserPersonality::class)->find($id);
        $manager->remove($userPersonality);
        $manager->flush();
        return $this->redirectToRoute('app_gestion_personnalite');

    }
    /**
     * @Route("/search/personality", name="search_personality")
     */
    public function search(Request $request)
    {
        $req = $request->request->get('req');
 
        if ($request->isXmlHttpRequest()) {
            $personalities=$this->getDoctrine()->getRepository(Personality::class)->findBy(['personalityId' => $req]);
            $jsonData = array();
            $idx = 0;
            foreach ($personalities as $personality) {
                $temp = array(
                    'personalityId' => $personality->getPersonalityId(),
                    'social' => $personality->getPersonalityId()[0],
                    'processing' => $personality->getPersonalityId()[1],
                    'decisionMaking' => $personality->getPersonalityId()[2],
                    'interaction' => $personality->getPersonalityId()[3],
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }
    }
}
