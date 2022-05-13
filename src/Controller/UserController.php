<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        //$user->setRoles(["CLIENT"]);
        $user->setCreatedDateUser(new \DateTime());
        $user->setLastUpdatedUser(new \DateTime());

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form->get('password')->getData()
            ));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/block/{id}", name="app_user_block")
     */
    public function block(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $user->setBlocked(true);
        $em->flush();
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/unblock/{id}", name="app_user_unblock")
     */
    public function debloquer(User $user, EntityManagerInterface $em): Response
    {
        $user->setBlocked(false);
        $em->flush();
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/search", name="search_user")
     */
    public function search(Request $request, UserRepository $userRepository)
    {
        $req = $request->request->get('req');

 
        if ($request->isXmlHttpRequest()) {
            $users = $userRepository->findUserByReq($req);
            $jsonData = array();
            $idx = 0;
            foreach ($users as $user) {
                $temp = array(
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRoles(),
                    'number' => $user->getNumber(),
                    'birthday' => $user->getBirthday(),
                    'id' => $user->getId()
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }
    }

    /* API */

    /**
     * @Route("/add", name="api_add_user")
     * methods={"POST"}
     */
    public function addUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $content = $request->getContent();
        $user = new User();
        $user->setFirstName($request->get('FirstName'));
        $user->setLastName($request->get('LastName'));
        $user->setEmail($request->get('Email'));
        $user->setPassword($request->get('Password'));
        $user->setNumber($request->get('Number'));
        $user->setBirthday(new \DateTime($request->get('Birthday')));
        //$user = $serializer->deserialize($content, User::class, 'json');
        $user->setCreatedDateUser(new \DateTime());
        $user->setLastUpdatedUser(new \DateTime());
        $em->persist($user);
        $em->flush();
        return new Response("User added successfully");
    }


    /**
     * @Route("/get-all", name="api_get_users", methods={"GET"})
     */
    public function getAllUsers(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $users = $userRepository->findAll();
        return new Response($serializer->serialize($users, 'json'));
    }

    /**
     * @Route("/get-user/{id}", name="api_get_user", methods={"GET"})
     */
    public function getSingleUser(SerializerInterface $serializer, User $user)
    {
        return new Response($serializer->serialize($user, 'json'));
    }

    /**
     * @Route("/update-user/{id}", name="api_update_user")
     * methods={"POST"}
     */
    public function editUser(Request $request, UserRepository $userRepository, SerializerInterface $serializer, EntityManagerInterface $em, User $user, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setFirstName($request->get('FirstName'));
        $user->setLastName($request->get('LastName'));
        $user->setEmail($request->get('Email'));
        $user->setPassword($request->get('Password'));
        $user->setNumber($request->get('Number'));
        //$user->setBirthday(new \DateTime($request->get('Birthday')));
        //$user = $serializer->deserialize($content, User::class, 'json');
        $user->setCreatedDateUser(new \DateTime());
        $user->setLastUpdatedUser(new \DateTime());
        $em->persist($user);

        $em->flush();
        return new Response("User Updated successfully");
    }

    /**
     * @Route("/block-user/{id}", name="api_block_user", )
     * methods={"POST"}
     */
    public function blockUser(User $user, EntityManagerInterface $em)
    {
        $user->setBlocked(true);
        $em->flush();
        return new Response("User Blocked successfully");
    }

    /**
     * @Route("/unblock-user/{id}", name="api_unblock_user",)
     * methods={"POST"}
     */
    public function unblockUser(User $user, EntityManagerInterface $em)
    {
        $user->setBlocked(false);
        $em->flush();
        return new Response("User Unblocked successfully");
    }
}
