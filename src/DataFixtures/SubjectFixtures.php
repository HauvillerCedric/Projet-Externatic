<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubjectFixtures extends Fixture
{
    public const SUBJECTS = [
        'Un problème technique',
        'Une question sur une offre d\'emploi',
        'Une question sur une entreprise',
        'Un problème sur votre profil',
        'Demande de suppression du compte de votre entreprise',
        'Autre',

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SUBJECTS as $subjectName) {
            $subject = new Subject();
            $subject->setName($subjectName);

            $manager->persist($subject);
        }

        $manager->flush();
    }
}
