<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModeleController extends AbstractController
{
    /**
     * @Route("/modeles", name="modeles")
     */
    public function modeles()
    {
        /** @var Modele[] $modeles */
        $modeles = $this->getDoctrine()->getRepository(Modele::class)->findAll();

        return $this->render('modele/all_modeles.html.twig', [
            'modeles' => $modeles,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/modele-add", name="modele_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(ModeleType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Modele $modele */
            $modele = $form->getData();

            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', 'Nouveau modèle ajouté!');
            return $this->redirectToRoute('modeles');
        }

        return $this->render('modele/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Modele $modele
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/modele/edit/{id}", name="modele_edit")
     */
    public function edit(Modele $modele, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModeleType::class, $modele);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', sprintf('Modèle "%s" modifié avec succès !', $modele->getNom()));
            return $this->redirectToRoute('modeles');
        }

        return $this->render('modele/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Modele $modele
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/modele/delete/{id}", name="modele_delete")
     */
    public function delete(Modele $modele, EntityManagerInterface $em)
    {
        $em->remove($modele);
        $em->flush();

        $this->addFlash('success', 'Modèle supprimé avec succès !');
        return $this->redirectToRoute('modeles');
    }
}
