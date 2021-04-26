<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookFixtures extends BaseFixture implements DependentFixtureInterface
{   
    protected $faker;

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Book::class, 100, function(Book $book, $count) {
            $book->setIsbn($this->faker->isbn10)
            ->setTitle($this->faker->words(3,true))
            ->setLength($this->faker->numberBetween(50,1000))
            ->setSlug($this->faker->slug)
            ->setTopcis($this->faker->text)
            ->setImgUrl('https://via.placeholder.com/350x570')
            ->setFileUrl('test.pdf')
            ->setCategory($this->getRandomReference(Category::class))
            ->setAuthor($this->getRandomReference(Author::class));
         
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixture::class,
            AuthorFixtures::class
           
        ];
    }
}
