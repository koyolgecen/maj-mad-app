<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Managers\LivraisonManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class LivraisonController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class LivraisonController extends AbstractController
{
    /** @var LivraisonManager */
    private $livraisonManager;

    /**
     * LivraisonController constructor.
     * @param LivraisonManager $livraisonManager
     */
    public function __construct(LivraisonManager $livraisonManager)
    {
        $this->livraisonManager = $livraisonManager;
    }

    /**
     * @param Request $request
     * @param Commande $commande
     * @return RedirectResponse|Response
     *
     * @Route("/livraison/{id}", name="commande_ship")
     */
    public function shipAction(Request $request, Commande $commande)
    {
        $form = $this->createForm(LivraisonType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $livraison = $form->getData();

            $this->livraisonManager->ship($livraison, $commande);

            $this->addFlash('success', sprintf('La livraison est entregistrée pour le devis - %s avec succès !', $commande->getDevis()));
            return $this->redirectToRoute('devis_item', [
                'id' => $commande->getDevis()->getId()
            ]);
        }
        return $this->render('livraison/add.html.twig', [
            'form' => $form->createView(),
            'devis' => $commande->getDevis()
        ]);
    }
}
