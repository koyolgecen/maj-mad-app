<?php

namespace App\Controller;

use App\Entity\ModeConception;
use App\Form\ModeConceptionType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ModeConceptionController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE')")
 */
class ModeConceptionController extends AbstractController
{
    /**
     * @Route("/modes-conception", name="modes_conception")
     */
    public function modesConception()
    {
        /** @var ModeConception[] $modesConception */
        $modesConception = $this->getDoctrine()->getRepository( ModeConception::class)->findAll();

        return $this->render('mode_conception/all_mode_conception.html.twig', [
            'modesConception' => $modesConception
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/mode-conception-add", name="mode_conception_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModeConceptionType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ModeConception $modeConception */
            $modeConception = $form->getData();

            $em->persist($modeConception);
            $em->flush();

            $this->addFlash('success', 'Nouveau mode de conception ajouté ');
            return $this->redirectToRoute('modes_conception');
        }

        return $this->render('mode_conception/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ModeConception $modeConception
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/mode-conception/edit/{id}", name="mode_conception_edit")
     */
    public function edit(ModeConception $modeConception, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModeConceptionType::class, $modeConception);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($modeConception);
            $em->flush();

            $this->addFlash('success', sprintf('Mode de conception "%s" modifié avec succès !', $modeConception->getType()));
            return $this->redirectToRoute('modes_conception', [
                'id' => $modeConception->getId()
            ]);
        }

        return $this->render('mode_conception/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $modeConception
        ]);
    }

    /**
     * @param ModeConception $modeConception
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/mode-conception/delete/{id}", name="mode_conception_delete")
     */
    public function delete(ModeConception $modeConception, EntityManagerInterface $em)
    {
        try {
            $em->remove($modeConception);
            $em->flush();
            $this->addFlash('success', 'Mode de conception supprimé avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! Le mode de conception est lié aux gammes "%s" !', implode(',', $modeConception->getGammes()->toArray())));
        }
        return $this->redirectToRoute('modes_conception');
    }
}
