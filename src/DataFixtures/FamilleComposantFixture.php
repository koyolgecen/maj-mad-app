<?php

namespace App\DataFixtures;

use App\Entity\FamilleComposant;
use Doctrine\Persistence\ObjectManager;

class FamilleComposantFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(15, 'composant_famille', function() {
            $familleComposant = new FamilleComposant();
            $familleComposant->setNomComposant($this->faker->text(40));
            return $familleComposant;
        });
        $manager->flush();
    }
}
