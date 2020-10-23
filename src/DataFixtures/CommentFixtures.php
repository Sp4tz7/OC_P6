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
        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('Woow no realy easy to do no?');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('Cool');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('Nice trick');
        $manager->persist($comment);
        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('This website is amazing');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('Goofy or regular mod');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('To easy');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('ahahahaha really??? that is not a mute!');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('sure it is!!!!');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('Not max amplitude');
        $manager->persist($comment);
        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('Ok come on... that is a mute!');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('Pedobear');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('Easy... my mum do the same!');
        $manager->persist($comment);
        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('Not all board allows to do this trick');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('AHHHAHAHA you need a flight attendant with this height');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('lol!');
        $manager->persist($comment);
        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('He should grab with other hand');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('Why?');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('why not!');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-01'));
        $comment->setMessage('Will I pass this openclassrooms test?');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-02'));
        $comment->setMessage('Yeah you will');
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setAuthor($this->getReference(UserFixtures::SUPERADMIN_USER_REFERENCE));
        $comment->setTrick($this->getReference(TrickFixtures::MUTE_TRICK_REFERENCE));
        $comment->setDateAdd(new \DateTime('2020-01-03'));
        $comment->setMessage('Simply do your best');
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
