<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\User;
use App\Managers\CommandeManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CommandeController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class CommandeController extends AbstractController
{
    /** @var CommandeManager */
    private $commandeManager;

    /**
     * CommandeController constructor.
     * @param CommandeManager $commandeManager
     */
    public function __construct(CommandeManager $commandeManager)
    {
        $this->commandeManager = $commandeManager;
    }

    /**
     * @param Devis $devis
     * @param MailerInterface $mailer
     * @return RedirectResponse
     *
     * @Route("/commande/{id}", name="commande_devis")
     */
    public function orderAction(Devis $devis, MailerInterface $mailer)
    {
        /** @var User $user */
        $user = $this->getUser();

        $this->commandeManager->order($devis, $user);

        $fournisseursToContact = $this->commandeManager->fournisseursToContact($devis);
        if (count($fournisseursToContact)) {
            foreach ($fournisseursToContact as $fournisseur => $composant) {
                $email = (new TemplatedEmail())
                    ->from(new Address('fournisseur-contact@madera.fr', 'MADERA'))
                    ->to(new Address($fournisseur, $composant['fournisseur']))
                    ->subject('Nouvelle commande pour MADERA')
                    ->htmlTemplate('email/fournisseur_commande.html.twig')
                    ->context([
                        'composant' => $composant['composant'],
                        'fournisseur' => $composant['fournisseur']
                    ]);
                try {
                    $mailer->send($email);
                } catch (TransportExceptionInterface $e) {
                }
            }
        }

        $this->addFlash('success', sprintf('Devis - %s commandé avec succès !', $devis));
        return $this->redirectToRoute('devis_item', [
            'id' => $devis->getId()
        ]);
    }

    /**
     * @param Devis $devis
     * @return RedirectResponse
     *
     * @Route("/annule-commande/{id}", name="commande_to_cancel")
     */
    public function toCancelAction(Devis $devis)
    {
        $this->commandeManager->toCancelOrder($devis);
        $this->addFlash('success', sprintf('La commande est annulée pour le devis - %s avec succès !', $devis));
        return $this->redirectToRoute('devis_item', [
            'id' => $devis->getId()
        ]);
    }
}
