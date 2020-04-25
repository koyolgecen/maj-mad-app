<?php

namespace App\Controller;

use App\Entity\Nature;
use App\Form\NatureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NatureController extends AbstractController
{
    /**
     * @Route("/natures", name="natures")
     */
    public function natures()
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        /** @var Nature[] $natures */
        $natures = $this->getDoctrine()->getRepository( Nature::class)->findAll();

        return $this->render('nature/all_natures.html.twig', [
            'natures' => $natures
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/nature-add", name="nature_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(NatureType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Nature $nature */
            $nature = $form->getData();

            $em->persist($nature);
            $em->flush();

            $this->addFlash('success', 'Nouvelle nature ajoutée!');
            return $this->redirectToRoute('natures');
        }

        return $this->render('nature/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Nature $nature
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/nature/edit/{id}", name="nature_edit")
     *
     */
    public function edit(Nature $nature, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(NatureType::class, $nature);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($nature);
            $em->flush();

            $this->addFlash('success', sprintf('Nature "%s" modifiée avec succès !', $nature->getNomNature()));
            return $this->redirectToRoute('nature_edit', [
                'id' => $nature->getId()
            ]);
        }

        return $this->render('nature/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $nature
        ]);
    }

    /**
     * @param Nature $nature
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/nature/delete/{id}", name="nature_delete")
     */
    public function delete(Nature $nature, EntityManagerInterface $em)
    {
        $em->remove($nature);
        $em->flush();

        $this->addFlash('success', 'Nature supprimée avec succès !');
        return $this->redirectToRoute('natures');
    }
}
