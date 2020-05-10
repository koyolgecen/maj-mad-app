<?php

namespace App\DataFixtures;

use App\Entity\ModuleARealiser;
use Doctrine\Persistence\ObjectManager;

class ModuleARealiserFixtures extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'modules_ar', function() {
            $module = new ModuleARealiser();
            $module->setNom($this->faker->word);
            $module->setModeConception($this->faker->word);
            $module->setLongueur($this->faker->numberBetween());
            $module->setLargeur($this->faker->numberBetween());
            return $module;
        });
        $manager->flush();
    }
}
