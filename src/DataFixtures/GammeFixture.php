<?php

namespace App\DataFixtures;

use App\Entity\CouvertureGamme;
use App\Entity\FinitionExterieurGamme;
use App\Entity\Gamme;
use App\Entity\IsolantGamme;
use App\Entity\ModeConception;
use App\Entity\Modele;
use App\Entity\QualiteHuisserieGamme;
use App\Entity\RegleCalcul;
use Doctrine\Persistence\ObjectManager;

class GammeFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'regle_de_calcul', function() {
            $regleCalcul = new RegleCalcul();
            $regleCalcul->setNom($this->faker->word);
            $regleCalcul->setCalcul($this->faker->randomFloat(2, 0.01, 10));
            return $regleCalcul;
        });
        $manager->flush();

        $reglesCalcul = $manager->getRepository(RegleCalcul::class)->findAll();
        $modesConception = ['Angle ouvrant', 'Angle fermant', 'Sans angle'];
        $this->createMany(count($modesConception), 'mode_conception', function($i) use ($modesConception, $reglesCalcul) {
            $modeConception = new ModeConception();
            $modeConception->setType($modesConception[$i]);
            $modeConception->setRegleCalcul($reglesCalcul[rand(0, count($reglesCalcul)-1)]);
            return $modeConception;
        });
        $manager->flush();

        $isolants = ['Laine de verre', 'Laine minérale', 'Polystyrène'];
        $this->createMany(count($isolants), 'isolants', function($i) use ($isolants) {
            $isolant = new IsolantGamme();
            $isolant->setNom($isolants[$i]);
            return $isolant;
        });
        $manager->flush();

        $couvertures = ['Tuile', 'Ardoise'];
        $this->createMany(count($couvertures), 'couvertures', function($i) use ($couvertures) {
            $couverture = new CouvertureGamme();
            $couverture->setNom($couvertures[$i]);
            return $couverture;
        });
        $manager->flush();

        $huisseries = ['PVC', 'Métal', 'Bois'];
        $this->createMany(count($huisseries), 'huisseries', function($i) use ($huisseries) {
            $huisserie = new QualiteHuisserieGamme();
            $huisserie->setNom($huisseries[$i]);
            return $huisserie;
        });
        $manager->flush();

        $finitions = ['PVC', 'Crépis', 'Bois', 'Synthétique'];
        $this->createMany(count($finitions), 'finitions', function($i) use ($finitions) {
            $finition = new FinitionExterieurGamme();
            $finition->setNom($finitions[$i]);
            return $finition;
        });
        $manager->flush();

        $gammes = ['Premium', 'Eco', 'Standard', 'Golden', 'Bestseller', 'Coup de Coeur', 'Mur extérieur crépis', 'Mur extérieur bois'];
        $modesConceptionObjets = $manager->getRepository(ModeConception::class)->findAll();
        $isolantsObjets = $manager->getRepository(IsolantGamme::class)->findAll();
        $couverturesObjets = $manager->getRepository(CouvertureGamme::class)->findAll();
        $huisseriesObjets = $manager->getRepository(QualiteHuisserieGamme::class)->findAll();
        $finitionsObjets = $manager->getRepository(FinitionExterieurGamme::class)->findAll();
        $modeles = $manager->getRepository(Modele::class)->findAll();

        $this->createMany(count($gammes), 'gammes', function($i) use ($gammes, $modesConceptionObjets, $isolantsObjets, $couverturesObjets, $huisseriesObjets, $finitionsObjets, $modeles) {
            $gamme = new Gamme();
            $gamme->setNom($gammes[$i]);
            $gamme->setModeConception($modesConceptionObjets[rand(0, count($modesConceptionObjets) - 1)]);
            $gamme->setIsolant($isolantsObjets[rand(0, count($isolantsObjets) - 1)]);
            $gamme->setCouverture($couverturesObjets[rand(0, count($couverturesObjets) - 1)]);
            $gamme->setQualitehuisserie($huisseriesObjets[rand(0, count($huisseriesObjets) - 1)]);
            $gamme->setFinitionExterieur($finitionsObjets[rand(0, count($finitionsObjets) - 1)]);
            $gamme->setModele($modeles[rand(0, count($modeles) - 1)]);
            return $gamme;
        });
        $manager->flush();
    }
}
