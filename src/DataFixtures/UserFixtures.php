<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const SUPERADMIN_USER_REFERENCE = 'super-admin-user';
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const USER_REFERENCE = 'user';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $superAdminUuser = new User();
        $superAdminUuser->setUsername('SuperAdmin');
        $superAdminUuser->setEmail('john.doe@example.com');
        $superAdminUuser->setPassword($this->encoder->encodePassword($superAdminUuser, 'superadmin123456789'));
        $superAdminUuser->setRoles(['ROLE_SUPER_ADMIN']);
        $superAdminUuser->setFirstname('John');
        $superAdminUuser->setLastname('Doe');
        $superAdminUuser->setIsActive(true);
        $superAdminUuser->setAvatar('default_avatar.png');
        $manager->persist($superAdminUuser);

        $adminUser = new User();
        $adminUser->setUsername('Admin');
        $adminUser->setEmail('janne.doe@example.com');
        $adminUser->setPassword($this->encoder->encodePassword($adminUser, 'admin123456789'));
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setFirstname('Janne');
        $adminUser->setLastname('Doe');
        $adminUser->setIsActive(true);
        $adminUser->setAvatar('default_avatar.png');
        $manager->persist($adminUser);

        $user = new User();
        $user->setUsername('User');
        $user->setEmail('danald.doe@example.com');
        $user->setPassword($this->encoder->encodePassword($user, 'user123456789'));
        $user->setRoles(['USER']);
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setIsActive(true);
        $user->setAvatar('default_avatar.png');
        $manager->persist($user);

        $manager->flush();

        $this->addReference(self::SUPERADMIN_USER_REFERENCE, $superAdminUuser);
        $this->addReference(self::ADMIN_USER_REFERENCE, $adminUser);
        $this->addReference(self::USER_REFERENCE, $user);
    }
}
