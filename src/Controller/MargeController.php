<?php

namespace App\Controller;

use App\Entity\Marge;
use App\Form\MargeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MargeController extends AbstractController
{
    /**
     * @Route("/marges", name="marges")
     */
    public function marges()
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        /** @var Marge[] $marges */
        $marges = $this->getDoctrine()->getRepository( Marge::class)->findAll();

        return $this->render('marge/all_marges.html.twig', [
            'marges' => $marges
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/marge-add", name="marge_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(MargeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Marge $marge */
            $marge = $form->getData();

            $em->persist($marge);
            $em->flush();

            $this->addFlash('success', 'Nouvelle marge ajoutée!');
            return $this->redirectToRoute('marges');
        }

        return $this->render('marge/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @param Marge $marge
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/marge/edit/{id}", name="app_marge_edit")
     *
     */
    public function edit(Marge $marge, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(MargeType::class, $marge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($marge);
            $em->flush();

            $this->addFlash('success', sprintf('Marge "%s" modifié avec succès !', $marge->getNom()));
            return $this->redirectToRoute('app_marge_edit', [
                'id' => $marge->getId()
            ]);
        }

        return $this->render('marge/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $marge
        ]);
    }

    /**
     * @param Marge $marge
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/marge/delete/{id}", name="marge_delete")
     */
    public function delete(Marge $marge, EntityManagerInterface $em)
    {
        $em->remove($marge);
        $em->flush();

        $this->addFlash('success', 'Marge supprimée avec succès !');
        return $this->redirectToRoute('marges');
    }
}
