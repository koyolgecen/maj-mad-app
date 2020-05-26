<?php

namespace App\Controller;

use App\Entity\CouvertureGamme;
use App\Form\CouvertureGammeType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouvertureGammeController extends AbstractController
{
    /**
     * @Route("/couvertures", name="couvertures")
     */
    public function couvertures()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var CouvertureGamme[] $couvertures */
        $couvertures = $this->getDoctrine()->getRepository( CouvertureGamme::class)->findAll();

        return $this->render('couverture_gamme/all_couvertures.html.twig', [
            'couvertures' => $couvertures
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/couverture-add", name="couverture_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(CouvertureGammeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CouvertureGamme $couverture */
            $couverture = $form->getData();

            $em->persist($couverture);
            $em->flush();

            $this->addFlash('success', 'Nouvelle couverture ajoutée!');
            return $this->redirectToRoute('couvertures');
        }

        return $this->render('couverture_gamme/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param CouvertureGamme $couverture
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/couverture/edit/{id}", name="couverture_edit")
     */
    public function edit(CouvertureGamme $couverture, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CouvertureGammeType::class, $couverture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($couverture);
            $em->flush();

            $this->addFlash('success', sprintf('Couverture "%s" modifiée avec succès !', $couverture->getNom()));
            return $this->redirectToRoute('couvertures', [
                'id' => $couverture->getId()
            ]);
        }

        return $this->render('couverture_gamme/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $couverture
        ]);
    }

    /**
     * @param CouvertureGamme $couverture
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/couverture/delete/{id}", name="couverture_delete")
     */
    public function delete(CouvertureGamme $couverture, EntityManagerInterface $em)
    {
        try {
            $em->remove($couverture);
            $em->flush();
            $this->addFlash('success', 'Couverture supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La couverture est liée aux gammes "%s" !', implode(',', $couverture->getGammes()->toArray())));
        }
        return $this->redirectToRoute('couvertures');
    }
}
