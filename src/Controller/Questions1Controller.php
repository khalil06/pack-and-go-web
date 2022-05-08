<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions1Controller extends AbstractController
{
    /**
     * @Route("/questions1", name="app_questions1")
     */
    public function index(Request $request): Response
    {
        //new int[5];// answer storing
        $questionNb = 1;
        $extroversionVsIntroversionTest = [
            "A. expend energy, enjoy groups. B. conserve energy, enjoy one-on-one :",
            "A. more outgoing, think out loud. B. more reserved, think to yourself :",
            "A. seek many tasks, public activities, interaction with others. :B. seek private solitary activities with quiet to concentrate :",
            "A. external, communicative,  express yourself. B. internal, reticent, keep to yourself :",
            "A. active, initiate. B. reflective, deliberate :",
        ];

        $formBuilder = $this->createFormBuilder();
        // $formBuilder->add('question', TextareaType::class, ['label' => 'Type your message here']);
        foreach ($extroversionVsIntroversionTest as $question) {
            $labelName = 'label' . (string)$questionNb;
            $formBuilder->add(
                $questionNb,
                ChoiceType::class,
                [
                    'label' => $question,
                    'choices' => [
                        'A' => 1,
                        'B' => 0,
                    ],
                    'expanded' => true
                ]
            );

            $questionNb++;
        }
        $formBuilder->add('send', SubmitType::class, ['label' => 'Send', 'attr' => ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full block']]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            return $this->redirectToRoute('app_questions2', ['data' => $data]);
        }
        return $this->render('questions1/index.html.twig', [
            'controller_name' => 'Questions1Controller',
            'form_questions1' => $form->createView(),
            'extroversionVsIntroversionTest' => $extroversionVsIntroversionTest,
        ]);
    }
}
