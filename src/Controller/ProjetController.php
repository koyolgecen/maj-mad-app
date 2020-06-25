<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Managers\ModuleARealiserManager;
use App\Services\ProjetService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjetController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class ProjetController extends AbstractController
{
    /** @var ModuleARealiserManager */
    private $moduleARealiserManager;
    /** @var Pdf */
    private $pdfGenerator;
    /** @var ProjetService */
    private $projetService;

    /**
     * ProjetController constructor.
     *
     * @param ModuleARealiserManager $moduleARealiserManager
     * @param Pdf $pdfGenerator
     * @param ProjetService $projetService
     */
    public function __construct(
        ModuleARealiserManager $moduleARealiserManager,
        Pdf $pdfGenerator,
        ProjetService $projetService
    ) {
        $this->moduleARealiserManager = $moduleARealiserManager;
        $this->pdfGenerator = $pdfGenerator;
        $this->projetService = $projetService;
    }

    /**
     * @Route("/projets", name="projets")
     */
    public function projets()
    {
        /** @var Projet[] $projets */
        $projets = $this->getDoctrine()->getRepository( Projet::class)->findAll();

        return $this->render('projet/all_projets.html.twig', [
            'projets' => $projets
        ]);
    }



    /**
     * @param Projet $projet
     * @return PdfResponse
     *
     * @Route("/dossier-technique-generate-pdf/{id}", name="dossier_technique_generate_pdf")
     */
    public function generatePdf(Projet $projet)
    {
        $html = $this->renderView('projet/pdf.html.twig', [
            'projet'  => $projet,
            'projetDetailled' => $this->projetService->getComposantsDetailled($projet),
        ]);

        return new PdfResponse(
            $this->pdfGenerator->getOutputFromHtml($html),
            sprintf('dossier_technique_%s.pdf', date('dmyHi'))
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/projet-add", name="projet_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProjetType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Projet $projet */
            $projet = $form->getData();

            $em->persist($projet);
            $em->flush();

            $this->moduleARealiserManager->createModulesARealiser($projet);

            $this->addFlash('success', 'Nouveau projet ajouté!');
            return $this->redirectToRoute('modules_ar', ['id' => $projet->getId()]);
        }

        return $this->render('projet/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Projet $projet
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/projet/edit/{id}", name="projet_edit")
     *
     */
    public function edit(Projet $projet, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', sprintf('Projet "%s" modifié avec succès !', $projet->getType()));
            return $this->redirectToRoute('projets');
        }

        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $projet
        ]);
    }

    /**
     * @param Projet $projet
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/projet/delete/{id}", name="projet_delete")
     */
    public function delete(Projet $projet, EntityManagerInterface $em)
    {
        $em->remove($projet);
        $em->flush();

        $this->addFlash('success', 'Projet supprimé avec succès !');
        return $this->redirectToRoute('projets');
    }
}
