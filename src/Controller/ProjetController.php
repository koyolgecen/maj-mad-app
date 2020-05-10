<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projets", name="projets")
     */
    public function projets()
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        /** @var Projet[] $projets */
        $projets = $this->getDoctrine()->getRepository( Projet::class)->findAll();

        return $this->render('projet/all_projets.html.twig', [
            'projets' => $projets
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/projet-add", name="projet_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(ProjetType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Projet $projet */
            $projet = $form->getData();

            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'Nouveau projet ajouté!');
            return $this->redirectToRoute('projets');
        }

        return $this->render('projet/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Projet $unite
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/projet/edit/{id}", name="projet_edit")
     *
     */
    public function edit(Projet $projet, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', sprintf('Projet "%s" modifié avec succès !', $projet->getType()));
            return $this->redirectToRoute('projet_edit', [
                'id' => $projet->getId()
            ]);
        }

        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $projet
        ]);
    }

    /**
     * @param Projet $projet
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/projet/delete/{id}", name="projet_delete")
     */
    public function delete(Projet $projet, EntityManagerInterface $em)
    {
        $em->remove($projet);
        $em->flush();

        $this->addFlash('success', 'Projet supprimé avec succès !');
        return $this->redirectToRoute('projets');
    }
}
