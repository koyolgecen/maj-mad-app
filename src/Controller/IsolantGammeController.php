<?php

namespace App\Controller;

use App\Entity\IsolantGamme;
use App\Form\IsolantGammeType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IsolantGammeController extends AbstractController
{
    /**
     * @Route("/isolants", name="isolants")
     */
    public function isolants()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var IsolantGamme[] $isolants */
        $isolants = $this->getDoctrine()->getRepository( IsolantGamme::class)->findAll();

        return $this->render('isolant_gamme/all_isolants.html.twig', [
            'isolants' => $isolants
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/isolant-add", name="isolant_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(IsolantGammeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var IsolantGamme $isolant */
            $isolant = $form->getData();

            $em->persist($isolant);
            $em->flush();

            $this->addFlash('success', 'Nouvel isolant ajouté!');
            return $this->redirectToRoute('isolants');
        }

        return $this->render('isolant_gamme/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param IsolantGamme $isolant
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/isolant/edit/{id}", name="isolant_edit")
     */
    public function edit(IsolantGamme $isolant, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(IsolantGammeType::class, $isolant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($isolant);
            $em->flush();

            $this->addFlash('success', sprintf('Isolant "%s" modifié avec succès !', $isolant->getNom()));
            return $this->redirectToRoute('isolants');
        }

        return $this->render('isolant_gamme/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $isolant
        ]);
    }

    /**
     * @param IsolantGamme $isolant
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/isolant/delete/{id}", name="isolant_delete")
     */
    public function delete(IsolantGamme $isolant, EntityManagerInterface $em)
    {
        try {
            $em->remove($isolant);
            $em->flush();
            $this->addFlash('success', 'Isolant supprimé avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! L\'isolant est lié aux gammes "%s" !', implode(',', $isolant->getGammes()->toArray())));
        }
        return $this->redirectToRoute('isolants');
    }
}
