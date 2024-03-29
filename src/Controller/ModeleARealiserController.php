<?php

namespace App\Controller;

use App\Entity\ModeleARealiser;
use App\Form\ModeleARealiserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ModeleARealiserController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class ModeleARealiserController extends AbstractController
{
    /**
     * @Route("/modeles-ar", name="modeles_ar")
     */
    public function modeles()
    {
        /** @var ModeleARealiser[] $modeles */
        $modeles = $this->getDoctrine()->getRepository( ModeleARealiser::class)->findAll();

        return $this->render('modele_a_realiser/all_modeles_ar.html.twig', [
            'modeles' => $modeles
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/modele-ar-add", name="modele_ar_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModeleARealiserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ModeleARealiser $modele */
            $modele = $form->getData();

            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', 'Nouveau modèle ajouté!');
            return $this->redirectToRoute('modeles_ar');
        }

        return $this->render('modele_a_realiser/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ModeleARealiser $modele
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/modele-ar/edit/{id}", name="modele_ar_edit")
     *
     */
    public function edit(ModeleARealiser $modele, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModeleARealiserType::class, $modele);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', sprintf('Modèle "%s" modifié avec succès !', $modele->getNom()));
            return $this->redirectToRoute('modeles_ar');
        }

        return $this->render('modele_a_realiser/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ModeleARealiser $modele
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/modele-ar/delete/{id}", name="modele_ar_delete")
     */
    public function delete(ModeleARealiser $modele, EntityManagerInterface $em)
    {
        $em->remove($modele);
        $em->flush();

        $this->addFlash('success', 'Modèle supprimé avec succès !');
        return $this->redirectToRoute('modeles_ar');
    }
}
