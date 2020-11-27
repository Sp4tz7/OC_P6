<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public const MUTE_TRICK_REFERENCE = 'trick-mute';
    public const OLLIE_TRICK_REFERENCE = 'trick-ollie';

    public function load(ObjectManager $manager)
    {
        $trickOllie = new Trick();
        $date = new \DateTime();
        $trickOllie->setName('Ollie');
        $trickOllie->setSlug('ollie');
        $trickOllie->setDescription('A trick in which the snowboarder springs off the tail of the board and into the air.');
        $trickOllie->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trickOllie->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trickOllie->setDateAdd($date);
        $trickOllie->setImage('default_image.jpg');
        $manager->persist($trickOllie);

        $image = new Image();
        $image->setName('Ollie');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trickOllie);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trickOllie);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Nollie');
        $trick->setSlug('nollie');
        $trick->setDescription('A trick in which the snowboarder springs off the nose of the board and into the air.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Nollie');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Switch ollie');
        $trick->setSlug('switch-ollie');
        $trick->setDescription('While riding switch, the snowboarder performs an ollie.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Switch ollie');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Tail grab');
        $trick->setSlug('tail-grab');
        $trick->setDescription('The rear hand grabs the tail of the snowboard. Variations include straightening, or boning the front leg, or tweaking the board slightly frontside or backside.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Tail grab');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Nose grab');
        $trick->setSlug('nose-grab');
        $trick->setDescription('The front hand grabs the nose of the snowboard.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Nose grab');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Japan air');
        $trick->setSlug('japan-air');
        $trick->setDescription('The front hand grabs the toe edge in between the feet and the front knee is pulled to the board.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Japan air');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Seatbelt');
        $trick->setSlug('seatbelt');
        $trick->setDescription('The front hand reaches across the body and grabs the tail while the front leg is boned. The snowboarders\'s arm resembles the sash of a three-point seatbelt, hence the name.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Seatbelt');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Truck driver');
        $trick->setSlug('truck-driver');
        $trick->setDescription('When both hands grab Indy and Melon.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Truck driver');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Crippler');
        $trick->setSlug('crippler');
        $trick->setDescription('An inverted 540 degree spin performed on the frontside wall of the halfpipe');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::ROTATION_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Crippler');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Mute');
        $trick->setSlug('mute');
        $trick->setDescription('The front hand grabs the toe edge either between the toes or in front of the front foot.');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Mute');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $manager->flush();

        $this->addReference(self::MUTE_TRICK_REFERENCE, $trick);
        $this->addReference(self::OLLIE_TRICK_REFERENCE, $trickOllie);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TrickCategoryFixtures::class,
        ];
    }
}
