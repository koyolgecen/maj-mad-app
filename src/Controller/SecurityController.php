<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use LogicException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     *
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

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
     * @param MailerInterface $mailer
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/register", name="app_register")
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

            $passwordNonEncode = $form['plainPassword']->getData();
            // On encode le password
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $passwordNonEncode
            ));

            $em->persist($user);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@madera.fr', 'MADERA'))
                ->to(new Address($user->getEmail(), $user->getPrenom()))
                ->subject('Votre compte chez MADERA')
                ->htmlTemplate('email/welcome.html.twig')
                ->context([
                    'user' => $user,
                    'password' => $passwordNonEncode
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
            }

            $this->addFlash('success', 'Nouvel utilisateur crée !');
            return $this->redirectToRoute('app_users');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
