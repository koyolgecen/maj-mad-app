<?php

namespace App\Managers;

use App\Entity\Commande;
use App\Entity\Devis;
use App\Entity\Livraison;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LivraisonManager
 * @package App\Managers
 */
class LivraisonManager
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * LivraisonManager constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function ship(Livraison $livraison, Commande $commande)
    {
        $livraison->setCommande($commande);
        $commande->setLivraison($livraison);
        $devis = $commande->getDevis();
        $devis->setEtat(Devis::ETAT_TRANSFERT_EN_FACTURATION);

        $this->em->persist($commande);
        $this->em->persist($livraison);
        $this->em->persist($devis);
        $this->em->flush();

    }
}