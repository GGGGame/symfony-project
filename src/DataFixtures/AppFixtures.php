<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    private $passwordHasherFactory;

    public function __construct(PasswordHasherFactoryInterface $encoderFactory)
    {
        $this->passwordHasherFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager): void
    {
        $italy = new Conference();
        $italy->setCity('Italy');
        $italy->setyear('2022');
        $italy->setIsInternational(false);
        $manager->persist($italy);

        $spain = new Conference();
        $spain->setCity('spain');
        $spain->setyear('2010');
        $spain->setIsInternational(true);
        $manager->persist($spain);

        $comment1 = new Comment();
        $comment1->setConference($italy);
        $comment1->setAuthor('Davide Ricca');
        $comment1->setEmail('davidericca109@gmail.com');
        $comment1->setText('Lorem ipsum');
        $manager->persist($comment1);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasherFactory->getPasswordHasher(Admin::class)->hash('admin', null));
        $manager->persist($admin);


        $manager->flush();
    }
}
