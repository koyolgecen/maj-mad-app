<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'produits', function() {
            $produit = new Produit();
            $produit->setNom($this->faker->word);
            return $produit;
        });
        $manager->flush();
    }
}
