<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrickCategoryFixtures extends Fixture
{
    public const GRAB_CATEGORY_REFERENCE = 'trick-grab';
    public const ROTATION_CATEGORY_REFERENCE = 'trick-rotation';

    public function load(ObjectManager $manager)
    {
        $category_grab = new TrickCategory();
        $category_grab->setName('Grabs');
        $category_grab->setSlug('grabs');
        $manager->persist($category_grab);

        $category_rotation = new TrickCategory();
        $category_rotation->setName('Rotations');
        $category_rotation->setSlug('rotation');
        $manager->persist($category_rotation);

        $manager->flush();

        $this->addReference(self::GRAB_CATEGORY_REFERENCE, $category_grab);
        $this->addReference(self::ROTATION_CATEGORY_REFERENCE, $category_rotation);

    }
}
