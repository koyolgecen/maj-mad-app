<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/users", name="app_users")
     */
    public function users()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var User[] $users */
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('account/all_users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="app_user_edit")
     *
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em)
    {
        /** @var User $userConnected */
        $userConnected = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'user' => $userConnected
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', sprintf('Utilisateur "%s" modifié avec succès !', $user->getUsername()));
            return $this->redirectToRoute('app_user_edit', [
                'id' => $user->getId()
            ]);
        }
        return $this->render('account/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);

    }
}
