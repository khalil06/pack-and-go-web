<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions4Controller extends AbstractController
{
    function sum($intArrays)
    {
        $sum = 0;
        foreach ($intArrays as $number) {
            $sum += $number;
        }
        return $sum;
    }
    /**
     * @Route("/questions4", name="app_questions4")
     */
    public function index(Request $request): Response
    {
        $extrovertVsIntrovertAnswersStorage = $_GET['extrovertVsIntrovertAnswersStorage'];
        $sensingVsIntuitionsAnswersStorage = $_GET['sensingVsIntuitionsAnswersStorage'];
        $thinkingVsFeelingAnswersStorage = $_GET['data'];
        $sumOfAsInThinking = self::sum($thinkingVsFeelingAnswersStorage);
        $answer = $_GET['answer'];
        echo $sumOfAsInThinking;

        if ($sumOfAsInThinking < 3)
            $answer = $answer . "F";
        else {
            $answer = $answer . "T";
        }
        echo $answer;
        $questionNb = 1;
        $judgingVsPerceivingTest = [
            "A. organized, orderly. B. flexible, adaptable",
            "A. plan, schedule B. unplanned, spontaneous",
            "A. regulated, structured B. easygoing, “live\" and “let live\"",
            "A. preparation, plan ahead. B. go with the flow, adapt as you go",
            "A. control, govern B. latitude, freedom"
        ];
        $formBuilder = $this->createFormBuilder();

        // $formBuilder->add('question', TextareaType::class, ['label' => 'Type your message here']);
        foreach ($judgingVsPerceivingTest as $question) {
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
            return $this->redirectToRoute('app_result', ['answer' => $answer, 'judgingVsPerceivingAnswersStorage' => $data,'thinkingVsFeelingAnswersStorage'=>$thinkingVsFeelingAnswersStorage , 'extrovertVsIntrovertAnswersStorage' => $extrovertVsIntrovertAnswersStorage, 'sensingVsIntuitionsAnswersStorage' => $sensingVsIntuitionsAnswersStorage]);
        }

        return $this->render('questions4/index.html.twig', [
            'controller_name' => 'Questions4Controller',
            'form_question4' => $form->createView(),
        ]);
    }
}
