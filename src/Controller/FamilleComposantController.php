<?php

namespace App\Controller;

use App\Entity\FamilleComposant;
use App\Form\FamilleComposantType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FamilleComposantController
 * @package App\Controller
 *
 */
class FamilleComposantController extends AbstractController
{
    /**
     * @Route("/famille-composants", name="famille_composants")
     */
    public function familleComposants()
    {
        /** @var FamilleComposant[] $familleComposants */
        $familleComposants = $this->getDoctrine()->getRepository(FamilleComposant::class)->findAll();

        return $this->render('famille_composant/all_famille_composants.html.twig', [
            'familleComposants' => $familleComposants
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/famille-composant-add", name="famille_composant_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(FamilleComposantType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FamilleComposant $familleComposant */
            $familleComposant = $form->getData();

            $em->persist($familleComposant);
            $em->flush();

            $this->addFlash('success', 'Nouvelle famille rajoutée!');
            return $this->redirectToRoute('famille_composants');
        }

        return $this->render('famille_composant/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param FamilleComposant $familleComposant
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/famille-composant/edit/{id}", name="famille_composant_edit")
     */
    public function edit(FamilleComposant $familleComposant, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(FamilleComposantType::class, $familleComposant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($familleComposant);
            $em->flush();

            $this->addFlash('success', sprintf('Famille composant "%s" modifiée avec succès !', $familleComposant->getNomComposant()));
            return $this->redirectToRoute('famille_composant_edit', [
                'id' => $familleComposant->getId()
            ]);
        }

        return $this->render('famille_composant/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param FamilleComposant $familleComposant
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/famille-composant/delete/{id}", name="famille_composant_delete")
     */
    public function delete(FamilleComposant $familleComposant, EntityManagerInterface $em)
    {
        try {
            $em->remove($familleComposant);
            $em->flush();
            $this->addFlash('success', 'Famille composant supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La famille composant est liée aux composants "%s" !', implode(',', $familleComposant->getComposants()->toArray())));
        }
        return $this->redirectToRoute('famille_composants');
    }
}
