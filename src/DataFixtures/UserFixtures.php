<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('SuperAdmin');
        $user->setEmail('example@example.com');
        $user->setPassword('admin123456789');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setIsActive(false);
        $manager->persist($user);

        $manager->flush();
    }
}
