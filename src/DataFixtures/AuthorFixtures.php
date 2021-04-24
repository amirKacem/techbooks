<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixtures extends BaseFixture
{   

    public function loadData(ObjectManager $manager) {
        $this->createMany(Author::class, 100, function(Author $author, $count) {
            $author->setFirstName($this->faker->firstName)
            ->setLastName($this->faker->lastname)
            ->setFullName($author->getFirstName().' '.$author->getLastName() );
        });
        $manager->flush();
    }

      
    
}
