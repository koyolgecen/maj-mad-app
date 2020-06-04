<?php

namespace App\Controller;

use App\Entity\Composant;
use App\Entity\FamilleComposant;
use App\Form\ComposantType;
use App\Form\FamilleComposantType;
use App\Form\FournisseurType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ComposantController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE')")
 */
class ComposantController extends AbstractController
{
    /**
     * @Route("/composants", name="composants")
     */
    public function composants()
    {
        /** @var Composant[] $composants */
        $composants = $this->getDoctrine()->getRepository(Composant::class)->findAll();

        return $this->render('composant/all_composants.html.twig', [
            'composants' => $composants
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/composant-add", name="composant_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ComposantType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FournisseurType $fournisseur */
            $composant = $form->getData();

            $em->persist($composant);
            $em->flush();

            $this->addFlash('success', 'Nouveau composant ajouté!');
            return $this->redirectToRoute('composants');
        }

        return $this->render('composant/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Composant $composant
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/composant/edit/{id}", name="composant_edit")
     */
    public function edit(Composant $composant, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ComposantType::class, $composant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($composant);
            $em->flush();

            $this->addFlash('success', sprintf('Composant "%s" modifiée avec succès !', $composant));
            return $this->redirectToRoute('composant_edit', [
                'id' => $composant->getId()
            ]);
        }

        return $this->render('composant/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Composant $composant
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/composant/delete/{id}", name="composant_delete")
     */
    public function delete(Composant $composant, EntityManagerInterface $em)
    {
        $em->remove($composant);
        $em->flush();

        $this->addFlash('success', 'Composant supprimé avec succès !');
        return $this->redirectToRoute('composants');
    }
}
