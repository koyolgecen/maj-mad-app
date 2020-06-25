<?php

namespace App\DataFixtures;

use App\Entity\Composant;
use App\Entity\FamilleComposant;
use App\Entity\Fournisseur;
use App\Entity\Marge;
use Doctrine\Persistence\ObjectManager;

class ComposantFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $famille = ['Construction', 'Consommable', 'Visserie'];
        $this->createMany(3, 'composant_famille', function($i) use ($famille) {
            $familleComposant = new FamilleComposant();
            $familleComposant->setNomComposant($famille[$i]);
            return $familleComposant;
        });
        $manager->flush();

        $this->createMany(10, 'marge', function() {
            $marge = new Marge();
            $marge->setNom($this->faker->word);
            $marge->setMargeCommerciale($this->faker->randomFloat(2, 0.01, 0.5));
            $marge->setMargeEntreprise($this->faker->randomFloat(2, 0.01, 0.5));
            return $marge;
        });
        $manager->flush();

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

        $familles = $manager->getRepository(FamilleComposant::class)->findAll();
        $marges = $manager->getRepository(Marge::class)->findAll();
        $fournisseurs = $manager->getRepository(Fournisseur::class)->findAll();
        $composants = ['Lisse', 'Contrefort', 'Sabot métallique', 'Boulon', 'Gougeon', 'Panneau d\'isolation', 'Plancher', 'Tuile', 'Ardoise', 'Ciment', 'Pare-pluie', 'Panneau intermédiaire'];

        $this->createMany(count($composants), 'composant', function($i) use ($composants, $familles, $marges, $fournisseurs) {
            $composant = new Composant();
            $composant->setNature($composants[$i]);
            $composant->setFamille($familles[rand(0, 2)]);
            $composant->setQuantite(rand(5, 800));
            $composant->setPrix($this->faker->randomFloat(2, 10, 100));
            $composant->setMarge($marges[rand(0,9)]);
            for ($j = 0; $j < rand(1, 5); $j++) {
                $k = rand(0, count($fournisseurs)-1);
                $composant->addFournisseur($fournisseurs[$k]);
            }
            return $composant;
        });
        $manager->flush();
    }
}
