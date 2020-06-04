<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FournisseurController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE')")
 */
class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseurs", name="fournisseurs")
     */
    public function fournisseurs()
    {
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
     * @Route("/fournisseur-add", name="fournisseur_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(FournisseurType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Fournisseur $fournisseur */
            $fournisseur = $form->getData();

            $em->persist($fournisseur);
            $em->flush();

            $this->addFlash('success', 'Nouveau fournisseur ajouté!');
            return $this->redirectToRoute('fournisseurs');
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
     * @Route("/fournisseur/edit/{id}", name="fournisseur_edit")
     */
    public function edit(Fournisseur $fournisseur, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($fournisseur);
            $em->flush();

            $this->addFlash('success', sprintf('Fournisseur "%s" modifié avec succès !', $fournisseur->getNom()));
            return $this->redirectToRoute('fournisseur_edit', [
                'id' => $fournisseur->getId()
            ]);
        }

        return $this->render('fournisseur/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Fournisseur $fournisseur
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/fournisseur/delete/{id}", name="fournisseur_delete")
     */
    public function delete(Fournisseur $fournisseur, EntityManagerInterface $em)
    {
        $em->remove($fournisseur);
        $em->flush();

        $this->addFlash('success', 'Fournisseur supprimé avec succès !');
        return $this->redirectToRoute('fournisseurs');
    }
}
