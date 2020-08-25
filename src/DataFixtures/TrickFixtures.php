<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $trick = new Trick();

        $date = new \DateTime('2020-01-01');
        $trick->setName('Mute');
        $trick->setSlug('mute');
        $trick->setDescription('saisie de la carre frontside de la planche entre les deux pieds avec la main avant');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::ROTATION_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);

        $manager->persist($trick);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TrickCategoryFixtures::class,
        ];
    }
}
