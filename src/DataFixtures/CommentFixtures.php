<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('Nice trick!');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('Yeah I agree');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('Easy... my mum do the same!');
        $manager->persist($comment);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TrickFixtures::class,
        ];
    }
}
