<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public const MUTE_TRICK_REFERENCE = 'trick-mute';

    public function load(ObjectManager $manager)
    {
        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Sad');
        $trick->setSlug('sad');
        $trick->setDescription('Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Sad');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Indy');
        $trick->setSlug('indy');
        $trick->setDescription('Saisie de la carre backside de la planche entre les deux pieds avec la main arrière ');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Indy');
        $image->setFileName('default_image.jpg');
        $image->setTrick($trick);
        $manager->persist($image);

        $video = new Video();
        $video->setTrick($trick);
        $video->setUrl('https://www.youtube.com/embed/CflYbNXZU3Q');
        $manager->persist($video);

        $trick = new Trick();
        $date = new \DateTime();
        $trick->setName('Stalefish');
        $trick->setSlug('stalefish');
        $trick->setDescription('Saisie de la carre backside de la planche entre les deux pieds avec la main arrière ');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Stalefish');
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
        $trick->setDescription('Saisie de la partie arrière de la planche, avec la main arrière');
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
        $trick->setDescription('Saisie de la partie avant de la planche, avec la main avant');
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
        $trick->setDescription('Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside');
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
        $trick->setName('Seat belt');
        $trick->setSlug('seat-belt');
        $trick->setDescription('Saisie du carre frontside à l\'arrière avec la main avante');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::GRAB_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('Seat belt');
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
        $trick->setDescription('Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture');
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
        $trick->setName('180');
        $trick->setSlug('180');
        $trick->setDescription('Un 180 désigne un demi-tour, soit 180 degrés d\'angle');
        $trick->setAddedBy($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick->addCategory($this->getReference(TrickCategoryFixtures::ROTATION_CATEGORY_REFERENCE));
        $trick->setDateAdd($date);
        $trick->setImage('default_image.jpg');
        $manager->persist($trick);

        $image = new Image();
        $image->setName('180');
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
        $trick->setDescription('Saisie de la carre frontside de la planche entre les deux pieds avec la main avant');
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
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TrickCategoryFixtures::class,
        ];
    }
}
