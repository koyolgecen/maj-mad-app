<?php

namespace App\Controller;

use App\Entity\QualiteHuisserieGamme;
use App\Form\QualiteHuisserieGammeType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QualiteHuisserieGammeController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE')")
 */
class QualiteHuisserieGammeController extends AbstractController
{
    /**
     * @Route("/qualites-huisseries", name="qualites_huisseries")
     */
    public function qualitesHuisseries()
    {
        /** @var QualiteHuisserieGamme[] $qualitesHuisseries */
        $qualitesHuisseries = $this->getDoctrine()->getRepository( QualiteHuisserieGamme::class)->findAll();

        return $this->render('qualite_huisserie_gamme/all_qualiteshuisseries.html.twig', [
            'qualitesHuisseries' => $qualitesHuisseries
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/qualite-huisserie-add", name="qualite_huisserie_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(QualiteHuisserieGammeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var QualiteHuisserieGamme $qualiteHuisserie */
            $qualiteHuisserie = $form->getData();

            $em->persist($qualiteHuisserie);
            $em->flush();

            $this->addFlash('success', 'Nouvelle qualité huisserie ajoutée ');
            return $this->redirectToRoute('qualites_huisseries');
        }

        return $this->render('qualite_huisserie_gamme/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param QualiteHuisserieGamme $qualiteHuisserie
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/qualite-huisserie/edit/{id}", name="qualite_huisserie_edit")
     */
    public function edit(QualiteHuisserieGamme $qualiteHuisserie, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(QualiteHuisserieGammeType::class, $qualiteHuisserie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($qualiteHuisserie);
            $em->flush();

            $this->addFlash('success', sprintf('Qualité huisserie "%s" modifiée avec succès !', $qualiteHuisserie->getNom()));
            return $this->redirectToRoute('qualites_huisseries', [
                'id' => $qualiteHuisserie->getId()
            ]);
        }

        return $this->render('qualite_huisserie_gamme/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $qualiteHuisserie
        ]);
    }

    /**
     * @param QualiteHuisserieGamme $qualiteHuisserie
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/qualite-huisserie/delete/{id}", name="qualite_huisserie_delete")
     */
    public function delete(QualiteHuisserieGamme $qualiteHuisserie, EntityManagerInterface $em)
    {
        try {
            $em->remove($qualiteHuisserie);
            $em->flush();
            $this->addFlash('success', 'Qualité huisserie supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La qualité huisserie  est liée aux gammes "%s" !', implode(',', $qualiteHuisserie->getGammes()->toArray())));
        }
        return $this->redirectToRoute('qualites_huisseries');
    }
}
