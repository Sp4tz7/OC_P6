<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('SuperAdmin');
        $user->setEmail('example@example.com');
        $user->setPassword($this->encoder->encodePassword($user, 'admin123456789'));
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setIsActive(false);
        $manager->persist($user);

        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

    }
}
