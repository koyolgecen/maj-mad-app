<?php

namespace App\Controller;

use App\Entity\CaracteristiqueNature;
use App\Form\CaracteristiqueNatureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaracteristiqueNatureController extends AbstractController
{
    /**
     * @Route("/caracs-nature", name="caracs")
     */
    public function caracs()
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        /** @var CaracteristiqueNature[] $caracs */
        $caracs = $this->getDoctrine()->getRepository( CaracteristiqueNature::class)->findAll();

        return $this->render('caracteristique_nature/all_caracs.html.twig', [
            'caracs' => $caracs
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/carac-nature-add", name="carac_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(CaracteristiqueNatureType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CaracteristiqueNature $carac */
            $carac = $form->getData();

            $em->persist($carac);
            $em->flush();

            $this->addFlash('success', 'Nouvelle caractéristique ajoutée!');
            return $this->redirectToRoute('caracs');
        }

        return $this->render('caracteristique_nature/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param CaracteristiqueNature $unite
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/carac-nature/edit/{id}", name="carac_edit")
     *
     */
    public function edit(CaracteristiqueNature $carac, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CaracteristiqueNatureType::class, $carac);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($carac);
            $em->flush();

            $this->addFlash('success', sprintf('Caractéristique "%s" modifiée avec succès !', $carac->getNomCaracNature()));
            return $this->redirectToRoute('carac_edit', [
                'id' => $carac->getId()
            ]);
        }

        return $this->render('caracteristique_nature/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $carac
        ]);
    }

    /**
     * @param CaracteristiqueNature $carac
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/carac-nature/delete/{id}", name="carac_delete")
     */
    public function delete(CaracteristiqueNature $carac, EntityManagerInterface $em)
    {
        $em->remove($carac);
        $em->flush();

        $this->addFlash('success', 'Caractéristique supprimée avec succès !');
        return $this->redirectToRoute('caracs');
    }
}
