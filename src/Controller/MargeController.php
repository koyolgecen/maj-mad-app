<?php

namespace App\Controller;

use App\Form\MargeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MargeController extends AbstractController
{
    /**
     * @Route("/marge", name="marge")
     */
    public function index()
    {
        return $this->render('marge/index.html.twig', [
            'controller_name' => 'MargeController',
        ]);
    }

    /**
     * @Route("/marge-add", name="marge_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(MargeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var MargeType $marge */
            $marge = $form->getData();

            $em->persist($marge);
            $em->flush();

            $this->addFlash('success', 'Nouvelle marge ajouée!');
            return $this->redirectToRoute('marge');
        }

        return $this->render('marge/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
