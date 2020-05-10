<?php

namespace App\Controller;

use App\Entity\Gamme;
use App\Form\GammeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GammeController extends AbstractController
{
    /**
     * @Route("/gammes", name="gammes")
     */
    public function fournisseurs()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var Gamme[] $gammes */
        $gammes = $this->getDoctrine()->getRepository( Gamme::class)->findAll();

        return $this->render('gamme/all_gammes.html.twig', [
            'gammes' => $gammes
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/gamme-add", name="gamme_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(GammeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Gamme $gamme */
            $gamme = $form->getData();

            $em->persist($gamme);
            $em->flush();

            $this->addFlash('success', 'Nouvelle gamme ajoutée!');
            return $this->redirectToRoute('gammes');
        }

        return $this->render('gamme/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Gamme $gamme
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/gamme/edit/{id}", name="gamme_edit")
     */
    public function edit(Gamme $gamme, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(GammeType::class, $gamme);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($gamme);
            $em->flush();

            $this->addFlash('success', sprintf('Gamme "%s" modifiée avec succès !', $gamme->getNom()));
            return $this->redirectToRoute('gammes', [
                'id' => $gamme->getId()
            ]);
        }

        return $this->render('gamme/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $gamme
        ]);
    }

    /**
     * @param Gamme $gamme
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/gamme/delete/{id}", name="gamme_delete")
     */
    public function delete(Gamme $gamme, EntityManagerInterface $em)
    {
        $em->remove($gamme);
        $em->flush();

        $this->addFlash('success', 'Gamme supprimée avec succès !');
        return $this->redirectToRoute('gammes');
    }
}
