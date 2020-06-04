<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/clients", name="clients")
     */
    public function clients()
    {
        /** @var Client[] $clients */
        $clients = $this->getDoctrine()->getRepository( Client::class)->findAll();

        return $this->render('client/all_clients.html.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/client-add", name="client_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ClientType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Client $client */
            $client = $form->getData();

            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'Nouveau client ajouté!');
            return $this->redirectToRoute('clients');
        }

        return $this->render('client/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Client $client
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/client/edit/{id}", name="client_edit")
     *
     */
    public function edit(Client $client, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($client);
            $em->flush();

            $this->addFlash('success', sprintf('Client "%s" modifiée avec succès !', $client->getNom()));
            return $this->redirectToRoute('client_edit', [
                'id' => $client->getId()
            ]);
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $client
        ]);
    }

    /**
     * @param Client $client
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/client/delete/{id}", name="client_delete")
     */
    public function delete(Client $client, EntityManagerInterface $em)
    {
        $em->remove($client);
        $em->flush();

        $this->addFlash('success', 'Client supprimé avec succès !');
        return $this->redirectToRoute('clients');
    }
}
