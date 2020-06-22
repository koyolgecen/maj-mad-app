<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\User;
use App\Form\DevisType;
use App\Services\DevisService;
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
 * Class DevisController
 * @package App\Controller
 *
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 * @author Clément COURTET <clement.courtet@viacesi.fr>
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 *
*  @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class DevisController extends AbstractController
{
    /** @var DevisService */
    private $devisService;
    /** @var Pdf */
    private $pdfGenerator;

    /**
     * DevisController constructor.
     * @param DevisService $devisService
     */
    public function __construct(DevisService $devisService, Pdf $pdfGenerator)
    {
        $this->devisService = $devisService;
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * Affichage des tous les devis en mode dataTable
     *
     * @Route("/devis", name="devis")
     */
    public function devis()
    {
        $devis = $this->getDoctrine()->getRepository(Devis::class)->findAll();

        return $this->render('devis/all_devis.html.twig', [
            'devis' => $devis
        ]);
    }

    /**
     * @param Devis $devis
     * @return PdfResponse
     *
     * @Route("/devis-generate-pdf/{id}", name="devis_generate_pdf")
     */
    public function generatePdf(Devis $devis)
    {
        $html = $this->renderView('devis/pdf.html.twig', [
            'devis'  => $devis,
            'devisDetailled' => $this->devisService->getComposantsDetailled($devis),
            'prixHTWithMarge' => $this->devisService->calculatePriceWithMargeHT($devis),
            'prixTTCWithMarge' => $this->devisService->calculatePriceWithMargeTTC($devis)
        ]);

        return new PdfResponse(
            $this->pdfGenerator->getOutputFromHtml($html),
            sprintf('%s-%s.pdf', $devis, date('d-m-y'))
        );
    }

    /**
     * Affichage d'un devis, on pourrait modifier son état et son paiement également
     *
     * @param Devis $devis
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @Route("/devis/{id}", name="devis_item")
     */
    public function item(Devis $devis, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(DevisType::class, $devis);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($devis);
            $em->flush();

            $this->addFlash('success', sprintf('Devis "%s" modifié avec succès !', $devis->getNom()));
            return $this->redirectToRoute('devis_item', [
                'id' => $devis->getId()
            ]);
        }

        return $this->render('devis/item.html.twig', [
            'devis' => $devis,
            'form' => $form->createView(),
            'prixHTWithMarge' => $this->devisService->calculatePriceWithMargeHT($devis),
            'prixTTCWithMarge' => $this->devisService->calculatePriceWithMargeTTC($devis),
            'devisDetailled' => $this->devisService->getComposantsDetailled($devis)
        ]);
    }

    /**
     * Création d'un devis
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/devis-add", name="devis_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(DevisType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Devis $devis */
            $devis = $form->getData();

            /** @var User $user */
            $user = $this->getUser();
            $devis->setVendeur($user);

            $em->persist($devis);
            $em->flush();

            $this->addFlash('success', 'Nouveau devis ajouté!');
            return $this->redirectToRoute('devis');
        }

        return $this->render('devis/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Suppression d'un devis
     *
     * @param Devis $devis
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/etat-devis/delete/{id}", name="devis_delete")
     */
    public function delete(Devis $devis, EntityManagerInterface $em)
    {
        $em->remove($devis);
        $em->flush();
        $this->addFlash('success', 'Devis supprimé avec succès !');
        return $this->redirectToRoute('devis');
    }
}
