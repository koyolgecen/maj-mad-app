<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'commercial_users', function() {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPrenom($this->faker->firstName);
            $user->setNom($this->faker->lastName);
            $user->setLogin($this->faker->userName);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "commercial"));
            $user->setRoles([User::ROLE_COMMERCIAL]);
            return $user;
        });

        $this->createMany(5, 'admin_users', function($i) {
            $user = new User();
            $user->setEmail(sprintf("admin%d@madera.fr", $i));
            $user->setPrenom($this->faker->firstName);
            $user->setNom($this->faker->lastName);
            $user->setLogin($this->faker->userName);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "admin"));
            $user->setRoles([User::ROLE_ADMIN]);
            return $user;
        });

        $this->createMany(5, 'bureau_detudes_users', function($i) {
            $user = new User();
            $user->setEmail(sprintf("bureauetude%d@madera.fr", $i));
            $user->setPrenom($this->faker->firstName);
            $user->setNom($this->faker->lastName);
            $user->setLogin($this->faker->userName);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "etude"));
            $user->setRoles([User::ROLE_BUREAU_DETUDE]);
            return $user;
        });
        $manager->flush();
    }
}
