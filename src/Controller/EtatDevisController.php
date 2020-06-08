<?php

namespace App\Controller;

use App\Entity\EtatDevis;
use App\Form\EtatDevisType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatDevisController extends AbstractController
{
    /**
     * @Route("/etats-devis", name="etat_devis")
     */
    public function etatsDevis()
    {
        $etatsDevis = $this->getDoctrine()->getRepository(EtatDevis::class)->findAll();

        return $this->render('etat_devis/all_etats_devis.html.twig', [
            'etatsdevis' => $etatsDevis,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/etat-devis-add", name="etat_devis_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(EtatDevisType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EtatDevis $etatDevis */
            $etatDevis = $form->getData();

            $em->persist($etatDevis);
            $em->flush();

            $this->addFlash('success', 'Nouvel état devis ajouté!');
            return $this->redirectToRoute('etat_devis');
        }

        return $this->render('etat_devis/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param EtatDevis $etatDevis
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/etat-devis/edit/{id}", name="etat_devis_edit")
     */
    public function edit(EtatDevis $etatDevis, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(EtatDevisType::class, $etatDevis);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($etatDevis);
            $em->flush();

            $this->addFlash('success', sprintf('Etat devis "%s" modifié avec succès !', $etatDevis->getNom()));
            return $this->redirectToRoute('etat_devis');
        }

        return $this->render('etat_devis/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param EtatDevis $etatDevis
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/etat-devis/delete/{id}", name="etat_devis_delete")
     */
    public function delete(EtatDevis $etatDevis, EntityManagerInterface $em)
    {
        try {
            $em->remove($etatDevis);
            $em->flush();
            $this->addFlash('success', 'Etat devis supprimé avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! L\'état devis est lié aux devis "%s" !', implode(',', $etatDevis->getDevis()->toArray())));
        }
        return $this->redirectToRoute('etat_devis');
    }
}
