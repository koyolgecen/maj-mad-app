<?php

namespace App\DataFixtures;

use App\Entity\Gamme;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;

class ProduitFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $produits = ['Premium', 'Eco', 'Standard', 'Golden', 'Bestseller', 'Coup de Coeur', 'Mur extérieur crépis', 'Mur extérieur bois'];
        $gammes = $manager->getRepository(Gamme::class)->findAll();
        $this->createMany(count($produits), 'produits', function($i) use ($produits, $gammes) {
            $produit = new Produit();
            $produit->setNom($produits[$i]);
            $produit->setGamme($gammes[rand(0, count($gammes)-1)]);
            return $produit;
        });
        $manager->flush();
    }
}
