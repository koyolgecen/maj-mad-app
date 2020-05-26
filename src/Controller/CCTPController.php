<?php

namespace App\Controller;

use App\Entity\CCTP;
use App\Form\CCTPType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CCTPController extends AbstractController
{
    /**
     * @Route("/cctp", name="cctps")
     */
    public function cctps()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var CCTP[] $cctp */
        $cctp = $this->getDoctrine()->getRepository( CCTP::class)->findAll();

        return $this->render('cctp/all_cctp.html.twig', [
            'cctp' => $cctp
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/cctp-add", name="cctp_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(CCTPType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CCTP $cctp */
            $cctp = $form->getData();

            $em->persist($cctp);
            $em->flush();

            $this->addFlash('success', 'Nouveau CCTP ajouté!');
            return $this->redirectToRoute('cctps');
        }

        return $this->render('cctp/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param CCTP $cctp
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/cctp/edit/{id}", name="cctp_edit")
     */
    public function edit(cctp $cctp, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CCTPType::class, $cctp);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($cctp);
            $em->flush();

            $this->addFlash('success', sprintf('CCTP "%s" modifié avec succès !', $cctp->getNom()));
            return $this->redirectToRoute('cctps');
        }

        return $this->render('cctp/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $cctp
        ]);
    }


    /**
     * @param cctp $cctp
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/cctp/delete/{id}", name="cctp_delete")
     */
    public function delete(cctp $cctp, EntityManagerInterface $em)
    {
        try {
            $em->remove($cctp);
            $em->flush();
            $this->addFlash('success', 'CCTP supprimé avec succès!');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! Le CCTP est lié aux modules "%s" !', implode(',', $cctp->getModules()->toArray())));
        }
        return $this->redirectToRoute('cctps');
    }

}
