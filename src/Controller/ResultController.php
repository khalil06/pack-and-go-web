<?php

namespace App\Controller;

use App\Entity\Personality;
use App\Entity\UserPersonality;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use DateTime;

class ResultController extends AbstractController
{
    public function countNumbers($numArray, $number)
    {
        $count = 0;
        foreach ($numArray as $num) {
            if ($num == $number)
                $count++;
        }
        return $count;
    }
    function sum($intArrays)
    {
        $sum = 0;
        foreach ($intArrays as $number) {
            $sum += $number;
        }
        return $sum;
    }
    /**
     * @Route("/result", name="app_result")
     */
    public function index(Session $session): Response
    {
        $extrovertVsIntrovertAnswersStorage = $_GET['extrovertVsIntrovertAnswersStorage'];
        $sensingVsIntuitionsAnswersStorage = $_GET['sensingVsIntuitionsAnswersStorage'];
        $thinkingVsFeelingAnswersStorage = $_GET['thinkingVsFeelingAnswersStorage'];
        $judgingVsPerceivingAnswersStorage = $_GET['judgingVsPerceivingAnswersStorage'];
        // $sumOfAsInThinking = self::sum($thinkingVsFeelingAnswersStorage);
        // $sumOfAsInSensing = self::sum($sensingVsIntuitionsAnswersStorage);
        // $sumOfAsInIntrovert = self::sum($extrovertVsIntrovertAnswersStorage);
        $sumOfAsInJudging = self::sum($judgingVsPerceivingAnswersStorage);
        $answer = $_GET['answer'];


        if ($sumOfAsInJudging < 3)
            $answer = $answer . "P";
        else {
            $answer = $answer . "J";
        }

        // look for a single Product by name
        $repository = $this->getDoctrine()->getRepository(Personality::class);
        $personality = $repository->findOneBy(['personalityId' => $answer]);

        //adding userpersonatliy
        $userPersonality = new UserPersonality();
        $userPersonality->setPersonalityId($answer);
        $userPersonality->setUserId("12");
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
        //adding userpersonatliy
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [
                ['Name', 'Proportions of answers'],
                ['Extroversion',   self::countNumbers($extrovertVsIntrovertAnswersStorage, 1)],
                ['Introversion',  self::countNumbers($extrovertVsIntrovertAnswersStorage, 0)],
                ['Sensing',  self::countNumbers($sensingVsIntuitionsAnswersStorage, 1)],
                ['Intuition',  self::countNumbers($sensingVsIntuitionsAnswersStorage, 0)],
                ['Thinking',  self::countNumbers($thinkingVsFeelingAnswersStorage, 1)],
                ['Feeling', self::countNumbers($thinkingVsFeelingAnswersStorage, 0)],
                ['Judging',  self::countNumbers($judgingVsPerceivingAnswersStorage, 1)],
                ['Perceiving',  self::countNumbers($judgingVsPerceivingAnswersStorage, 0)]

            ]
        );
        $pieChart->getOptions()->setTitle('My Daily Activities');
        $pieChart->getOptions()->setHeight(450);
        $pieChart->getOptions()->setWidth(450);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $pieChart->getOptions()->setBackgroundColor("#f8f9fa");

        $histogram = new Histogram();
        $histogram->getData()->setArrayToDataTable([
            ['Personality Trait', 'trait 1'],
            ['Extroversion',   self::countNumbers($extrovertVsIntrovertAnswersStorage, 1)],
            ['Introversion',  self::countNumbers($extrovertVsIntrovertAnswersStorage, 0)],
            ['Sensing',  self::countNumbers($sensingVsIntuitionsAnswersStorage, 1)],
            ['Intuition',  self::countNumbers($sensingVsIntuitionsAnswersStorage, 0)],
            ['Thinking',  self::countNumbers($thinkingVsFeelingAnswersStorage, 1)],
            ['Feeling', self::countNumbers($thinkingVsFeelingAnswersStorage, 0)],
            ['Judging',  self::countNumbers($judgingVsPerceivingAnswersStorage, 1)],
            ['Perceiving',  self::countNumbers($judgingVsPerceivingAnswersStorage, 0)]

        ]);
        $histogram->getOptions()->setTitle('Personality Traits');
        $histogram->getOptions()->setWidth(450);
        $histogram->getOptions()->setHeight(450);
        $histogram->getOptions()->getLegend()->setPosition('none');
        $histogram->getOptions()->setColors(['#e7711c']);
        $histogram->getOptions()->setBackgroundColor('#f8f9fa');

        // $histogram->getOptions()->getHistogram()->setLastBucketPercentile(10);
        // $histogram->getOptions()->getHistogram()->setBucketSize(10000000);
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable([
            ['Personality Trait', 'trait 1', 'trait 2'],
            ['Extroversion VS Introversion',   self::countNumbers($extrovertVsIntrovertAnswersStorage, 1),  self::countNumbers($extrovertVsIntrovertAnswersStorage, 0)],

            ['Sensing VS Intuition',  self::countNumbers($sensingVsIntuitionsAnswersStorage, 1), self::countNumbers($sensingVsIntuitionsAnswersStorage, 0)],

            ['Thinking VS Feeling',  self::countNumbers($thinkingVsFeelingAnswersStorage, 1), self::countNumbers($thinkingVsFeelingAnswersStorage, 0)],

            ['Judging VS Perceiving',  self::countNumbers($judgingVsPerceivingAnswersStorage, 1), self::countNumbers($judgingVsPerceivingAnswersStorage, 0)],

        ]);
        $bar->getOptions()->setTitle('Form Statistics');
        $bar->getOptions()->getHAxis()->setTitle('Your answer');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Personality Trait');
        $bar->getOptions()->setWidth(800);
        $bar->getOptions()->setHeight(450);
        $bar->getOptions()->setBackgroundColor("#f8f9fa");
        return $this->render('result/index.html.twig', [
            'controller_name' => 'ResultController',
            'result' => $answer,
            'data' => $judgingVsPerceivingAnswersStorage,
            'personality' => $personality,
            'piechart' => $pieChart,
            'histogram' => $histogram,
            'chart' => $bar
        ]);
    }
}
