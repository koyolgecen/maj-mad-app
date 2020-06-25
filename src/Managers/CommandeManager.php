<?php


namespace App\Managers;

use App\Entity\Commande;
use App\Entity\Devis;
use App\Entity\User;
use App\Services\DevisService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CommandeManager
 * @package App\Managers
 *
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class CommandeManager
{
    /** @var DevisService */
    private $devisService;
    /** @var EntityManagerInterface */
    private $em;

    /**
     * CommandeManager constructor.
     *
     * @param DevisService $devisService
     * @param EntityManagerInterface $em
     */
    public function __construct(DevisService $devisService, EntityManagerInterface $em)
    {
        $this->devisService = $devisService;
        $this->em = $em;
    }

    /**
     * @param Devis $devis
     * @param User $user
     * @return array
     */
    public function order(Devis $devis, User $user): array
    {
        $erreur = [];
        foreach ($devis->getComposants() as $composant) {
            if ($composant->getQuantite() === 0 or $composant->getQuantite() < 0) {
                $erreur[] = sprintf('Le composant %s est manquant dans le stock la commande n\'est pas pu passée.', $composant);
            }
        }
        if (empty($erreur)) {
            $prixTTC = $this->devisService->calculatePriceWithMargeTTC($devis);

            $commande = new Commande();
            $commande->setMontant($prixTTC);
            $commande->setVendeur($user);
            $commande->setDevis($devis);
            $this->em->persist($commande);
            $this->em->flush();

            $devis->setEtat(Devis::ETAT_EN_COMMANDE);
            $devis->setCommande($commande);
            foreach ($devis->getComposants() as $composant) {
                $composant->setQuantite(($composant->getQuantite() - 1));
            }
            $this->em->flush();
        }
        return $erreur;
    }

    /**
     * @param Devis $devis
     * @return array
     */
    public function fournisseursToContact(Devis $devis): array
    {
        $result = [];
        foreach ($devis->getComposants() as $composant) {
            if ($composant->getQuantite() <= 5) {
                foreach ($composant->getFournisseurs() as $fournisseur) {
                    $result[$fournisseur->getMail()] = [
                        'fournisseur' => $fournisseur->getNom(),
                        'composant' => $composant->getNature()
                    ];
                }
            }
        }
        return $result;
    }

    public function toCancelOrder(Devis $devis)
    {
        foreach ($devis->getComposants() as $composant) {
            $composant->setQuantite(($composant->getQuantite() + 1));
        }
        $this->em->remove($devis->getCommande());
        $devis->setCommande(null);
        $devis->setEtat(Devis::ETAT_ACCEPTE);
        $this->em->flush();
    }

}