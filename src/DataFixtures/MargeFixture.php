<?php

namespace App\DataFixtures;

use App\Entity\Marge;
use Doctrine\Persistence\ObjectManager;

class MargeFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'marge', function() {
            $marge = new Marge();
            // TODO mithat set nom
            $marge->setMargeCommerciale($this->faker->randomFloat(2, 0, 1));
            $marge->setMargeEntreprise($this->faker->randomFloat(2, 0, 1));
            return $marge;
        });
        $manager->flush();
    }
}
