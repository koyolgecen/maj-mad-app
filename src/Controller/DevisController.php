<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevisController extends AbstractController
{
    /**
     * @Route("/devis", name="devis")
     */
    public function devis()
    {
        $devis = $this->getDoctrine()->getRepository(Devis::class)->findAll();

        return $this->render('devis/all_devis.html.twig', [
            'devis' => $devis
        ]);
    }

    /**
     * @param Devis $devis
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @Route("/devis/{id}", name="devis_item")
     */
    public function item(Devis $devis, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(DevisType::class, $devis);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($devis);
            $em->flush();

            $this->addFlash('success', sprintf('Devis "%s" modifié avec succès !', $devis->getNom()));
            return $this->redirectToRoute('devis_item', [
                'id' => $devis->getId()
            ]);
        }

        return $this->render('devis/item.html.twig', [
            'devis' => $devis,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/devis-add", name="devis_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(DevisType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Devis $devis */
            $devis = $form->getData();

            $em->persist($devis);
            $em->flush();

            $this->addFlash('success', 'Nouveau devis ajouté!');
            return $this->redirectToRoute('devis');
        }

        return $this->render('devis/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Devis $devis
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/etat-devis/delete/{id}", name="devis_delete")
     */
    public function delete(Devis $devis, EntityManagerInterface $em)
    {
        $em->remove($devis);
        $em->flush();
        $this->addFlash('success', 'Devis supprimé avec succès !');
        return $this->redirectToRoute('devis');
    }
}
