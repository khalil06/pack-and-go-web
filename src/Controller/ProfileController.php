<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function getMyProfile(): Response
    {
        return $this->render('profile/index.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @Route("/profile/{id}", name="app_profile_id")
     */
    public function getProfile(User $user): Response
    {
        return $this->render('profile/index.html.twig', ['user' => $user]);
    }
}