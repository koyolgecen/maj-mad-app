<?php


namespace App\Managers;

use App\Entity\Commande;
use App\Entity\Devis;
use App\Entity\EtatDevis;
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
     */
    public function order(Devis $devis, User $user): void
    {
        $etatDevisRepo = $this->em->getRepository(EtatDevis::class);

        $prixTTC = $this->devisService->calculatePriceWithMargeTTC($devis);

        $commande = new Commande();
        $commande->setMontant($prixTTC);
        $commande->setVendeur($user);
        $this->em->persist($commande);
        $this->em->flush();

        /** @var EtatDevis|null $etatDevis */
        $etatDevis = $etatDevisRepo->findOneByNom('commande');
        if (!is_null($etatDevis)) {
            $devis->setEtat($etatDevis);
        }
        $devis->setCommande($commande);
        foreach ($devis->getComposants() as $composant) {
            $composant->setQuantite(($composant->getQuantite() - 1));
        }
        $this->em->flush();
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
                    $result[$fournisseur->getMail()] = $composant->getNature();
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
        $this->em->flush();
    }

}