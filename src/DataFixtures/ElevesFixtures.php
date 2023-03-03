<?php

namespace App\DataFixtures;

use App\Entity\Eleves;
use App\Entity\Niveau;
use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ElevesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
        $niveau = "CE1";
        $classe = "A";
        for ($i=0; $i<6; $i++) {
            $eleve = new Eleves();
            $eleve->setFirstname($faker->firstName);
            $eleve->setLastname($faker->lastName);
            $eleve->setCodemassar($faker->unixTime($max='now'));
            $eleve->setImage($faker->image());
            $eleve->setCreatedAt(new \DateTimeImmutable('now'));
            $eleve->setUpdatedAt(new \DateTimeImmutable('now'));
            $eleve->setNiveau('CE1');
            $eleve->setClasse('A');
            $manager->persist($eleve);
            
        }

        $manager->flush();
    }
}
