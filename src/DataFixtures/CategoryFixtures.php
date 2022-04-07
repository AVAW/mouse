<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $categoriesName = [
            'ladies',
            'gentlemen',
            'clubs',
            'couples',
            'massage',
            'bdms',
            'striptease',
            'shows-phone-sex',
        ];

        foreach ($categoriesName as $name) {
            $category = (new Category())
                ->setName($name);

            $manager->persist($category);

            //$this->addReference();
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['Prod'];
    }
}
