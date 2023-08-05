<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Développeur Back End',
        'Développeur Front End',
        'Développeur Full Stack',
        'DevOps',
        'Lead technique',
        'Architecte Infrastructure',
        'Scrum master',
        'Product owner',
        'Product Manager',
        'Ingénieur Test',
        'UX / UI designer',
        'Administrateur Système & Réseaux',
        'Ingénieur Système Cloud',
        'Architecte Logiciel',
        'Ingénieur Hardware',
        'Analyste fonctionnel / AMOA',
        'Intégrateur Web',
        'Ingénieur Logiciel Embarqué',
        'Technicien support',

    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
        }
        $manager->flush();
    }
}
