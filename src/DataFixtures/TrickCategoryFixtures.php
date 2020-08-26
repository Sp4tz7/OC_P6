<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrickCategoryFixtures extends Fixture
{
    public const GRAB_CATEGORY_REFERENCE = 'trick-grab';
    public const ROTATION_CATEGORY_REFERENCE = 'trick-rotation';
    public const FLIP_CATEGORY_REFERENCE = 'trick-flip';
    public const SLIDES_CATEGORY_REFERENCE = 'trick-slides';
    public const ONEFOOT_CATEGORY_REFERENCE = 'trick-onefoot';
    public const OLDSCHOOLD_CATEGORY_REFERENCE = 'trick-oldschool';

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

        $category_flip = new TrickCategory();
        $category_flip->setName('Flips');
        $category_flip->setSlug('flip');
        $manager->persist($category_flip);

        $category_slide = new TrickCategory();
        $category_slide->setName('Slides');
        $category_slide->setSlug('slides');
        $manager->persist($category_slide);

        $category_onefoot = new TrickCategory();
        $category_onefoot->setName('One foot');
        $category_onefoot->setSlug('one-foot');
        $manager->persist($category_onefoot);

        $category_oldschool = new TrickCategory();
        $category_oldschool->setName('Old school');
        $category_oldschool->setSlug('old-school');
        $manager->persist($category_oldschool);

        $manager->flush();

        $this->addReference(self::GRAB_CATEGORY_REFERENCE, $category_grab);
        $this->addReference(self::ROTATION_CATEGORY_REFERENCE, $category_rotation);
        $this->addReference(self::FLIP_CATEGORY_REFERENCE, $category_flip);
        $this->addReference(self::SLIDES_CATEGORY_REFERENCE, $category_slide);
        $this->addReference(self::ONEFOOT_CATEGORY_REFERENCE, $category_onefoot);
        $this->addReference(self::OLDSCHOOLD_CATEGORY_REFERENCE, $category_oldschool);
    }
}
