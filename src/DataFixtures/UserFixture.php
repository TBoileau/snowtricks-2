<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $user = new User;
        $user
            ->setEmail("admin@demo.fr")
            ->setPassword($this->encoder->encodePassword($user, "demodemo"))
            ->setUsername("Admindemo")
            ->setRoles(["ROLE_ADMIN", "ROLE_USER"]);
        $manager->persist($user);

        $user = new User;
        $user
            ->setEmail("user@demo.fr")
            ->setPassword($this->encoder->encodePassword($user, "demodemo"))
            ->setUsername("Userdemo")
            ->setRoles(["ROLE_USER"]);
        $manager->persist($user);


        for ($i = 0; $i < 20; $i++) {
            $roles = ["ROLE_USER"];
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setPassword($this->encoder->encodePassword($user, "demodemo"))
                ->setUsername($faker->firstName())
                ->setRoles($roles);

            $manager->persist($user);
        }

        $manager->flush();
    }
}

