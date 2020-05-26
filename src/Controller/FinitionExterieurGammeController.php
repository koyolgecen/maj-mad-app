<?php

namespace App\Controller;

use App\Entity\FinitionExterieurGamme;
use App\Form\FinitionExterieurGammeType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinitionExterieurGammeController extends AbstractController
{
    /**
     * @Route("/finitions-exterieures", name="finitions_exterieures")
     */
    public function finitionsExterieures()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var FinitionExterieurGamme[] $finitionsExterieures */
        $finitionsExterieures = $this->getDoctrine()->getRepository( FinitionExterieurGamme::class)->findAll();

        return $this->render('finition_exterieur_gamme/all_finition_exterieur_gamme.html.twig', [
            'finitionsExterieures' => $finitionsExterieures
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/finition-exterieur-add", name="finition_exterieur_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(FinitionExterieurGammeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FinitionExterieurGamme $finitionExterieur */
            $finitionExterieur = $form->getData();

            $em->persist($finitionExterieur);
            $em->flush();

            $this->addFlash('success', 'Nouvelle finition extérieure ajoutée ');
            return $this->redirectToRoute('finitions_exterieures');
        }

        return $this->render('finition_exterieur_gamme/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param FinitionExterieurGamme $finitionExterieur
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/finition-exterieur/edit/{id}", name="finition_exterieur_edit")
     */
    public function edit(FinitionExterieurGamme $finitionExterieur, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(FinitionExterieurGammeType::class, $finitionExterieur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($finitionExterieur);
            $em->flush();

            $this->addFlash('success', sprintf('Finition extérieure "%s" modifiée avec succès !', $finitionExterieur->getNom()));
            return $this->redirectToRoute('finitions_exterieures', [
                'id' => $finitionExterieur->getId()
            ]);
        }

        return $this->render('finition_exterieur_gamme/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $finitionExterieur
        ]);
    }

    /**
     * @param FinitionExterieurGamme $finitionExterieur
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/finition-exterieur/delete/{id}", name="finition_exterieur_delete")
     */
    public function delete(FinitionExterieurGamme $finitionExterieur, EntityManagerInterface $em)
    {
        try {
            $em->remove($finitionExterieur);
            $em->flush();
            $this->addFlash('success', 'Finition extérieure supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La finition extérieure est liée aux gammes "%s" !', implode(',', $finitionExterieur->getGammes()->toArray())));
        }
        return $this->redirectToRoute('finitions_exterieures');
    }
}
