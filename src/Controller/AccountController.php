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
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        /** @var User[] $users */
        $users = $userRepository->findAll();

        return $this->render('account/all_users.html.twig', [
            'users' => $users,
            'admins' => count($userRepository->findByRole(User::ROLE_ADMIN)),
            'commercials' => count($userRepository->findByRole(User::ROLE_COMMERCIAL)),
            'bureaudetudes' => count($userRepository->findByRole(User::ROLE_BUREAU_DETUDE))
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
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
     * @return RedirectResponse
     *
     * @Route("/user/delete/{id}", name="app_user_delete")
     */
    public function delete(User $user, EntityManagerInterface $em)
    {
        if ($user === $this->getUser()) {
            $this->addFlash('danger', sprintf('Vous êtes connecté en tant que %s vous ne pouvez pas vous supprimer vous-même!', $this->getUser()->getUsername()));
        } else {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès !');
        }
        return $this->redirectToRoute('app_users');
    }
}
