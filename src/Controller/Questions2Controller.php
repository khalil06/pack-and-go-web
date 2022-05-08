<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions2Controller extends AbstractController
{
    /**
     * @Route("/questions2", name="app_questions2")
     */
    public function index(Request $request): Response
    {
        $extrovertVsIntrovertAnswersStorage = $_GET['data'];
        $sumOfAsInExtroversion = self::sum($extrovertVsIntrovertAnswersStorage);
        $answer = "";
        echo $sumOfAsInExtroversion;
        if ($sumOfAsInExtroversion < 3)
            $answer = "I";
        else {
            $answer = "E";
        }

        $questionNb = 1;
        $sensingVsIntuitionTest = [
            "A. interpret literally. B. look for meaning and possibilities",
            "A. practical, realistic, experiential. B. imaginative, innovative, theoretical",
            "A. standard, usual, conventional. B. different, novel, unique",
            "A. focus on here-and-now\" .B.look to the future, global perspective, \"big picture\"",
            "A. facts, things, \"what is\". B. ideas, dreams, \"what could be,\" philosophical"
        ];


        $formBuilder = $this->createFormBuilder();

        // $formBuilder->add('question', TextareaType::class, ['label' => 'Type your message here']);
        foreach ($sensingVsIntuitionTest as $question) {
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
        $formBuilder->add('send', SubmitType::class, ['label' => 'Send', 'attr' => ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            return $this->redirectToRoute('app_questions3', ['answer' => $answer, 'data' => $data,'extrovertVsIntrovertAnswersStorage' => $extrovertVsIntrovertAnswersStorage]);
        }
        return $this->render('questions2/index.html.twig', [
            'controller_name' => 'Questions2Controller',
            'form_questions2' => $form->createView(),
        ]);
    }
    function sum($intArrays)
    {
        $sum = 0;
        foreach ($intArrays as $number) {
            $sum += $number;
        }
        return $sum;
    }
}
