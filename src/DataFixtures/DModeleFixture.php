<?php

namespace App\DataFixtures;

use App\Entity\CCTP;
use App\Entity\Composant;
use App\Entity\CoupeDePrincipe;
use App\Entity\Modele;
use App\Entity\Module;
use Doctrine\Persistence\ObjectManager;

class DModeleFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $coupes = ['Coupe mur extérieur', 'Coupe mur intérieur', 'Coupe toiture', 'Coupe mur en travers'];
        $this->createMany(4, 'coupe_de_principe', function($i) use ($coupes) {
            $coupeDePrincipe = new CoupeDePrincipe();
            $coupeDePrincipe->setNom($coupes[$i]);
            $coupeDePrincipe->setTypeCoupePrincipe($coupes[$i]);
            return $coupeDePrincipe;
        });
        $manager->flush();

        $cctps = ['Béton ciré', 'Béton armé', 'Béton imprimé'];
        $this->createMany(3, 'cctps', function($i) use ($cctps) {
            $cctp = new CCTP();
            $cctp->setNom($cctps[$i]);
            $cctp->setLongueur($this->faker->randomFloat(2, 0.01, 10));
            $cctp->setLargeur($this->faker->randomFloat(2, 0.01,5));
            return $cctp;
        });
        $manager->flush();

        $modules = ['Mur extérieur', 'Mur intérieur', 'Cloison intérieur', 'Plancher sur dalle', 'Plancher porteur', 'Ferme de charpente', 'Couverture'];
        $cctpsObjects = $manager->getRepository(CCTP::class)->findAll();
        $coupesObjects = $manager->getRepository(CoupeDePrincipe::class)->findAll();
        $composants = $manager->getRepository(Composant::class)->findAll();
        $this->createMany(count($modules), 'modules', function($i) use ($modules, $cctpsObjects, $coupesObjects, $composants) {
            $module = new Module();
            $module->setNom($modules[$i]);
            $module->setQuantite(rand(1, 10));
            $module->setCctp($cctpsObjects[rand(0, count($cctpsObjects)-1)]);
            $module->setCoupeDePrincipe($coupesObjects[rand(0, count($coupesObjects)-1)]);
            for ($j = 0; $j < rand(5, 10); $j++) {
                $module->addModuleComposant($composants[rand(0, count($composants)-1)]);
            }
            return $module;
        });
        $manager->flush();

        $modeles = ['A étage', 'Classique', 'Moderne', 'Avec garage', 'Plain-pied'];
        $modulesObjects = $manager->getRepository(Module::class)->findAll();
        $this->createMany(count($modeles), 'modeles', function($i) use ($modeles, $modulesObjects) {
            $modele = new Modele();
            $modele->setNom($modeles[$i]);
            for ($j = 0; $j < rand(1, 5); $j++) {
                $modele->addModule($modulesObjects[rand(0, count($modulesObjects)-1)]);
            }
            return $modele;
        });
        $manager->flush();
    }
}
