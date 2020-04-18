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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     *
     * @Route("/user/edit/{id}", name="app_user_edit")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        /** @var User $userConnected */
        $userConnected = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'user' => $userConnected,
            'modification' => true
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if (!is_null($form['plainPassword']->getData())) {
                // On encode le password
                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $form['plainPassword']->getData()
                ));
            }

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


    /**
     * @param User $user
     * @param EntityManagerInterface $em
     *
     * @Route("/user/delete/{id}", name="app_user_delete")
     */
    public function delete(User $user, EntityManagerInterface $em)
    {

    }
}
