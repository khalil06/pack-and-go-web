<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_user_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository) 
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_user_index');
        }

        if($request->isMethod("POST")) {
            $exist = $userRepository->findOneBy(['email' => $request->request->get('email')]);
            if($exist) {
                $this->addFlash(
                    'error',
                    'Email déja utilisé !'
                );
                return $this->redirect($request->getRequestUri());
            }
            $user = new User();
            $user->setEmail($request->request->get('email'));
            $user->setFirstName($request->request->get('firstname'));
            $user->setLastName($request->request->get('lastname'));
            $user->setNumber($request->request->get('number'));
            $birthday = \DateTime::createFromFormat("Y-m-d", $request->request->get('birthday'));
            $user->setBirthday($birthday);
            $user->setCreatedDateUser(new \DateTime());
            $user->setLastUpdatedUser(new \DateTime());
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $request->request->get('password')
            ));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("app_login");
        }

        return $this->render('security/register.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        $this->redirect("app_login");
    }
}
