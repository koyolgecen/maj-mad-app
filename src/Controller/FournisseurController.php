<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseurs", name="fournisseurs")
     */
    public function index()
    {
        /** @var Fournisseur[] $fournisseurs */
        $fournisseurs = $this->getDoctrine()->getRepository(Fournisseur::class)->findAll();
        return $this->render('fournisseur/index.html.twig', [
            'controller_name' => 'FournisseurController',
            'fournisseurs' => $fournisseurs
        ]);
    }

    /**
     * @Route("/fournisseur-add", name="fournisseur_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
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
            return $this->redirectToRoute('fournisseurs');
        }

        return $this->render('fournisseur/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
