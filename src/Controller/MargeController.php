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
     * @Route("/marge", name="marge")
     */
    public function index()
    {
        /** @var Marge[] $marges */
        $marges = $this->getDoctrine()->getRepository(Marge::class)->findAll();
        return $this->render('marge/index.html.twig', [
            'controller_name' => 'MargeController',
            'marges' => $marges
        ]);
    }


    /**
     * @Route("/marges", name="app_marges")
     */
    public function marges()
    {
        $this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        /** @var Marge[] $marges */
        $marges = $this->getDoctrine()->getRepository( Marge::class)->findAll();

        return $this->render('marges/all_marges.html.twig', [
            'marges' => $marges
        ]);
    }


    /**
     * @Route("/marge-add", name="marge_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
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

            $this->addFlash('success', 'Nouvelle marge ajouée!');
            return $this->redirectToRoute('marge');
        }

        return $this->render('marge/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/marge/edit/{id}", name="app_marge_edit")
     *
     * @param Marge $marge
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
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
     * @Route("/marge/delete/{id}", methods={"DELETE"})
     * @param EntityManagerInterface $em
     * @param Request $request
     */
    public function delete(Request $request, $id)
    {
        $marges = $this->getDoctrine()->getRepository( Marge::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($marges);
        $em->flush();

        $response = new Response();
        $response->send();
    }
}
