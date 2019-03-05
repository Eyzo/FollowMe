<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1;$i <= 12;$i++) {

            $user = new User();
            $user->setEmail($faker->email);
            $plainPassword = 'Berserk62155';
            $encoded = $this->encoder->encodePassword($user,$plainPassword);
            $user->setPassword($encoded);
            $user->setRoles(array('ROLE_USER'));

            $manager->persist($user);

            $profile = new Profile();
            $profile->setName($faker->name);
            $profile->setDescription($faker->paragraph(6,true));
            $profile->setSubscribe(array());
            $profile->setSubscribers(array());
            $profile->setUser($user);

            $manager->persist($profile);
        }

        $manager->flush();
    }
}
