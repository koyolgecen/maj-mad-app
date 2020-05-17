<?php

namespace App\Controller;

use App\Entity\CaracteristiqueNature;
use App\Form\CaracteristiqueNatureType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaracteristiqueNatureController extends AbstractController
{
    /**
     * @Route("/caracterisques-nature", name="caracteristiques_nature")
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
     * @Route("/caracterisque-nature-add", name="caracteristiques_nature_add")
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
            return $this->redirectToRoute('caracteristiques_nature');
        }

        return $this->render('caracteristique_nature/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param CaracteristiqueNature $carac
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/caracterisque-nature/edit/{id}", name="caracteristiques_nature_edit")
     */
    public function edit(CaracteristiqueNature $carac, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CaracteristiqueNatureType::class, $carac);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($carac);
            $em->flush();

            $this->addFlash('success', sprintf('Caractéristique "%s" modifiée avec succès !', $carac->getNomCaracNature()));
            return $this->redirectToRoute('caracteristiques_nature');
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
     * @Route("/caracterisque-nature/delete/{id}", name="caracteristiques_nature_delete")
     */
    public function delete(CaracteristiqueNature $carac, EntityManagerInterface $em)
    {
        try {
            $em->remove($carac);
            $em->flush();
            $this->addFlash('success', 'Caractéristique supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La caractéristique est liée aux natures "%s" !', implode(',', $carac->getNatures()->toArray())));
        }
        return $this->redirectToRoute('caracteristiques_nature');
    }
}
