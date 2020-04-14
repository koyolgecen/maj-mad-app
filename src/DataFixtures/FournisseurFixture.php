<?php

namespace App\DataFixtures;

use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;

class FournisseurFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'fournisseurs', function() {
            $fournisseur = new Fournisseur();
            $fournisseur->setNom($this->faker->company);
            $fournisseur->setAdresse($this->faker->address);
            $fournisseur->setCodePostale($this->faker->postcode);
            $fournisseur->setMail($this->faker->companyEmail);
            $fournisseur->setTelephone($this->faker->phoneNumber);
            return $fournisseur;
        });
        $manager->flush();
    }
}
