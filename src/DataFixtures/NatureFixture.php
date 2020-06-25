<?php

namespace App\DataFixtures;

use App\Entity\CaracteristiqueNature;
use App\Entity\Nature;
use App\Entity\UniteNature;
use Doctrine\Persistence\ObjectManager;

class NatureFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'caracteristique_nature', function() {
            $caracteristiqueNature = new CaracteristiqueNature();
            $caracteristiqueNature->setNomCaracNature($this->faker->word);
            $caracteristiqueNature->setDescCaracNature($this->faker->text(500));
            return $caracteristiqueNature;
        });
        $manager->flush();

        $unites = ['m2', 'm3', 'kg', 'g', 'mg'];

        $this->createMany(5, 'unites', function($i) use ($unites) {
            $unite = new UniteNature();
            $unite->setUniteUsageNature($unites[$i]);
            $unite->setDescUniteNature($this->faker->text(500));
            return $unite;
        });
        $manager->flush();

        $caracteristiquesNatures = $manager->getRepository(CaracteristiqueNature::class)->findAll();
        $unitesNatures = $manager->getRepository(UniteNature::class)->findAll();
        $natures = ['Isolation', 'Ossature', 'Dalle', 'Couverture'];

        $this->createMany(4, 'natures', function($i) use ($caracteristiquesNatures, $unitesNatures, $natures) {
            $nature = new Nature();
            $nature->setNomNature($natures[$i]);
            $nature->setUniteNature($unitesNatures[rand(0, count($unitesNatures)-1)]);
            $nature->setCaracteristiqueNature($caracteristiquesNatures[rand(0, count($caracteristiquesNatures)-1)]);
            return $nature;
        });
        $manager->flush();

    }
}
