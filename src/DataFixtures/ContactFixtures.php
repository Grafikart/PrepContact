<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixtures extends Fixture implements FixtureGroupInterface
{

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['contact'];
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $contact = (new Contact())
                ->setName("John $i")
                ->setMessage("Hello this is a test $i")
                ->setPhone("0000000000")
                ->setEmail("john$i@doe.fr")
                ->setCreatedAt(new \DateTime());
            $manager->persist($contact);
        }

        $manager->flush();
    }
}
