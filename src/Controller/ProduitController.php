<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE')")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function produits()
    {
        /** @var Produit[] $produits */
        $produits = $this->getDoctrine()->getRepository( Produit::class)->findAll();

        return $this->render('produit/all_produits.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/produit-add", name="produit_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProduitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Produit $produit */
            $produit = $form->getData();

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Nouveau produit ajouté!');
            return $this->redirectToRoute('produits');
        }

        return $this->render('produit/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Produit $produit
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/produit/edit/{id}", name="produit_edit")
     *
     */
    public function edit(Produit $produit, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', sprintf('Produit "%s" modifié avec succès !', $produit->getNom()));
            return $this->redirectToRoute('produits', [
                'id' => $produit->getId()
            ]);
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $produit
        ]);
    }

    /**
     * @param Produit $produit
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/produit/delete/{id}", name="produit_delete")
     */
    public function delete(Produit $produit, EntityManagerInterface $em)
    {
        $em->remove($produit);
        $em->flush();

        $this->addFlash('success', 'Produit supprimé avec succès !');
        return $this->redirectToRoute('produits');
    }

}
