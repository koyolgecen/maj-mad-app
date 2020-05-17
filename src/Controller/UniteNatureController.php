<?php

namespace App\Controller;

use App\Entity\UniteNature;
use App\Form\UniteNatureType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UniteNatureController extends AbstractController
{
    /**
     * @Route("/unites-nature", name="unites")
     */
    public function unites()
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        /** @var UniteNature[] $unites */
        $unites = $this->getDoctrine()->getRepository( UniteNature::class)->findAll();

        return $this->render('unite_nature/all_unites.html.twig', [
            'unites' => $unites
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/unite-nature-add", name="unite_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(UniteNatureType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UniteNature $unite */
            $unite = $form->getData();

            $em->persist($unite);
            $em->flush();

            $this->addFlash('success', 'Nouvelle unité ajoutée!');
            return $this->redirectToRoute('unites');
        }

        return $this->render('unite_nature/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param UniteNature $unite
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/unite-nature/edit/{id}", name="unite_edit")
     *
     */
    public function edit(UniteNature $unite, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(UniteNatureType::class, $unite);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($unite);
            $em->flush();

            $this->addFlash('success', sprintf('Unité "%s" modifié avec succès !', $unite->getDescUniteNature()));
            return $this->redirectToRoute('unites');
        }

        return $this->render('unite_nature/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $unite
        ]);
    }

    /**
     * @param UniteNature $unite
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/unite-nature/delete/{id}", name="unite_delete")
     */
    public function delete(UniteNature $unite, EntityManagerInterface $em)
    {
        try {
            $em->remove($unite);
            $em->flush();
            $this->addFlash('success', 'Unité supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! L\'unité est liée aux natures "%s" !', implode(',', $unite->getNatures()->toArray())));
        }
        return $this->redirectToRoute('unites');
    }
}
