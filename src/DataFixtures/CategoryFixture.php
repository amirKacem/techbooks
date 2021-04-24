<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixture extends BaseFixture
{   
    protected $faker;

    public function loadData(ObjectManager $manager) {
        $this->createMany(Category::class, 10, function(Category $category, $count) {
            $category->setName($this->faker->name)
            ->setDescription($this->faker->text);
        });
        $manager->flush();
    }
}
