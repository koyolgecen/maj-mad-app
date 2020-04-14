<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use LogicException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register")
     * @param MailerInterface $mailer
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(MailerInterface $mailer, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Si on n'est pas admin on ne peut pas ajouter un utilisateur
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            // On encode le password
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form['plainPassword']->getData()
            ));

            $em->persist($user);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from('no-reply@madera.fr')
                ->to($user->getEmail())
                ->subject('Bienvenue chez MADERA !')
                ->htmlTemplate('email/welcome.html.twig')
                ->context([
                    'user' => $user
                ]);
            $mailer->send($email);

            $this->addFlash('success', 'Nouvel utilisateur crée !');
            return $this->redirectToRoute('app_users');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
