<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseurs", name="app_fournisseurs")
     */
    public function fournisseurs()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var Fournisseur[] $fournisseurs */
        $fournisseurs = $this->getDoctrine()->getRepository( Fournisseur::class)->findAll();

        return $this->render('fournisseur/all_fournisseurs.html.twig', [
            'fournisseurs' => $fournisseurs
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/fournisseur-add", name="app_fournisseur_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(FournisseurType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Fournisseur $fournisseur */
            $fournisseur = $form->getData();

            $em->persist($fournisseur);
            $em->flush();

            $this->addFlash('success', 'Nouveau fournisseur ajouté!');
            return $this->redirectToRoute('app_fournisseurs');
        }

        return $this->render('fournisseur/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Fournisseur $fournisseur
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/fournisseur/edit/{id}", name="app_fournisseur_edit")
     */
    public function edit(Fournisseur $fournisseur, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($fournisseur);
            $em->flush();

            $this->addFlash('success', sprintf('Fournisseur "%s" modifié avec succès !', $fournisseur->getNom()));
            return $this->redirectToRoute('app_fournisseur_edit', [
                'id' => $fournisseur->getId()
            ]);
        }

        return $this->render('fournisseur/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $fournisseur
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @Route("/fournisseur/delete/{id}", methods={"DELETE"})
     */
    public function delete(Request $request, $id){

        $fournisseurs = $this->getDoctrine()->getRepository( Fournisseur::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($fournisseurs);
        $em->flush();

        $response = new Response();
        $response->send();
    }
}
