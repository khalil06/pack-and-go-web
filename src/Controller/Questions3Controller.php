<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Questions3Controller extends AbstractController
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
     * @Route("/questions3", name="app_questions3")
     */
    public function index(Request $request): Response
    {
        $extrovertVsIntrovertAnswersStorage = $_GET['extrovertVsIntrovertAnswersStorage'];
        $sensingVsIntuitionsAnswersStorage = $_GET['data'];
        $sumOfAsInSensing = self::sum($sensingVsIntuitionsAnswersStorage);
        $answer = $_GET['answer'];
        echo $sumOfAsInSensing;

        if ($sumOfAsInSensing < 3)
            $answer = $answer . "N";
        else {
            $answer = $answer . "S";
        }
        echo $answer;

        $questionNb = 1;
        $thinkingVsFeelingTest = [
            "A. logical, thinking, questioning. B. empathetic, feeling, accommodating",
            "B. candid, straight forward, frank. B.tactful, kind, encouraging",
            "A. firm, tend to criticize, hold the line. B. gentle, tend to appreciate, conciliate",
            "A. tough-minded, just B.tender-hearted, merciful",
            "A. matter of fact, issue-oriented B. sensitive, people-oriented, compassionate",
        ];
        $formBuilder = $this->createFormBuilder();

        // $formBuilder->add('question', TextareaType::class, ['label' => 'Type your message here']);
        foreach ($thinkingVsFeelingTest as $question) {
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
            return $this->redirectToRoute('app_questions4', ['answer' => $answer, 'data' => $data, 'extrovertVsIntrovertAnswersStorage' => $extrovertVsIntrovertAnswersStorage, 'sensingVsIntuitionsAnswersStorage' => $sensingVsIntuitionsAnswersStorage]);
        }
        return $this->render('questions3/index.html.twig', [
            'controller_name' => 'Questions2Controller',
            'form_question3' => $form->createView(),
        ]);

        // return $this->render('questions3/index.html.twig', [
        //     'controller_name' => 'Questions3Controller',
        // ]);
    }
}
