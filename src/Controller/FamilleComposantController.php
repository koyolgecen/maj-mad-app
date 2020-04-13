<?php

namespace App\Controller;

use App\Entity\FamilleComposant;
use App\Form\FamilleComposantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FamilleComposantController
 * @package App\Controller
 *
 */
class FamilleComposantController extends AbstractController
{
    /**
     * @Route("/famille-composant", name="famille_composant")
     */
    public function index()
    {
        return $this->render('famille_composant/index.html.twig', [
            'controller_name' => 'FamilleComposantController',
        ]);
    }

    /**
     * @Route("/famille-composant-add", name="famille_composant_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(FamilleComposantType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FamilleComposant $familleComposant */
            $familleComposant = $form->getData();

            $em->persist($familleComposant);
            $em->flush();

            $this->addFlash('success', 'Nouvelle famille rajoutée!');
            return $this->redirectToRoute('famille_composant');
        }

        return $this->render('famille_composant/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
