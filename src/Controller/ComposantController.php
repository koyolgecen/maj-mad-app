<?php

namespace App\Controller;

use App\Form\ComposantType;
use App\Form\FournisseurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ComposantController extends AbstractController
{
    /**
     * @Route("/composants", name="composants")
     */
    public function index()
    {
        return $this->render('composant/index.html.twig', [
            'controller_name' => 'ComposantController',
        ]);
    }

    /**
     * @Route("/composant-add", name="composant_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(ComposantType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FournisseurType $fournisseur */
            $composant = $form->getData();

            $em->persist($composant);
            $em->flush();

            $this->addFlash('success', 'Nouveau composant ajouté!');
            return $this->redirectToRoute('composants');
        }

        return $this->render('composant/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
