<?php

namespace App\Controller;

use App\Entity\RegleCalcul;
use App\Form\RegleCalculType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegleCalculController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE')")
 */
class RegleCalculController extends AbstractController
{
    /**
     * @Route("/regles-calcul", name="regles_calcul")
     */
    public function reglesCalcul()
    {
        /** @var RegleCalcul[] $reglesCalcul */
        $reglesCalcul = $this->getDoctrine()->getRepository( RegleCalcul::class)->findAll();

        return $this->render('regle_calcul/all_regles_calcul.html.twig', [
            'reglesCalcul' => $reglesCalcul
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/regle-calcul-add", name="regle_calcul_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(RegleCalculType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RegleCalcul $regleCalcul */
            $regleCalcul = $form->getData();

            $em->persist($regleCalcul);
            $em->flush();

            $this->addFlash('success', 'Nouvelle règle de calcul ajoutée ');
            return $this->redirectToRoute('regles_calcul');
        }

        return $this->render('regle_calcul/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param RegleCalcul $regleCalcul
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/regle-calcul/edit/{id}", name="regle_calcul_edit")
     */
    public function edit(RegleCalcul $regleCalcul, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(RegleCalculType::class, $regleCalcul);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($regleCalcul);
            $em->flush();

            $this->addFlash('success', sprintf('Règle de calcul "%s" modifiée avec succès !', $regleCalcul->getNom()));
            return $this->redirectToRoute('regles_calcul', [
                'id' => $regleCalcul->getId()
            ]);
        }

        return $this->render('regle_calcul/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $regleCalcul
        ]);
    }

    /**
     * @param RegleCalcul $regleCalcul
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/regle-calcul/delete/{id}", name="regle_calcul_delete")
     */
    public function delete(RegleCalcul $regleCalcul, EntityManagerInterface $em)
    {
        try {
            $em->remove($regleCalcul);
            $em->flush();
            $this->addFlash('success', 'Règle de calcul supprimée avec succès !\'');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La règle de calcul est liée aux modes de conception "%s" !', implode(',', $regleCalcul->getModeConceptions()->toArray())));
        }
        return $this->redirectToRoute('regles_calcul');
    }
}
