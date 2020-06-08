<?php

namespace App\Controller;

use App\Entity\PaiementEchelonne;
use App\Form\PaiementEchelonneType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementEchelonneController extends AbstractController
{
    /**
     * @Route("/paiements-echelonne", name="paiements_echelonnes")
     */
    public function paiementsEchelonne()
    {
        /** @var PaiementEchelonne[] $paiementsEchelonne */
        $paiementsEchelonne = $this->getDoctrine()->getRepository(PaiementEchelonne::class)->findAll();

        return $this->render('paiement_echelonne/all_paiements_echelonne.html.twig', [
            'paiementsEchelonne' => $paiementsEchelonne,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/paiement-echelonne-add", name="paiement_echelonne_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(PaiementEchelonneType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PaiementEchelonne $paiementEchelonne */
            $paiementEchelonne = $form->getData();

            $em->persist($paiementEchelonne);
            $em->flush();

            $this->addFlash('success', 'Nouveau paiement échelonné ajouté!');
            return $this->redirectToRoute('paiements_echelonnes');
        }

        return $this->render('paiement_echelonne/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param PaiementEchelonne $paiementEchelonne
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/paiement-echelonne/edit/{id}", name="paiement_echelonne_edit")
     */
    public function edit(PaiementEchelonne $paiementEchelonne, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(PaiementEchelonneType::class, $paiementEchelonne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($paiementEchelonne);
            $em->flush();

            $this->addFlash('success', sprintf('Paiement échelonné "%s" modifié avec succès !', $paiementEchelonne->getNomEtape()));
            return $this->redirectToRoute('paiements_echelonnes');
        }

        return $this->render('paiement_echelonne/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param PaiementEchelonne $paiementEchelonne
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/paiement-echelonne/delete/{id}", name="paiement_echelonne_delete")
     */
    public function delete(PaiementEchelonne $paiementEchelonne, EntityManagerInterface $em)
    {
        try {
            $em->remove($paiementEchelonne);
            $em->flush();
            $this->addFlash('success', 'Paiement écholonné supprimé avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! Le paiement écholonné est lié aux devis "%s" !', implode(',', $paiementEchelonne->getDevis()->toArray())));
        }
        return $this->redirectToRoute('paiements_echelonnes');
    }
}
