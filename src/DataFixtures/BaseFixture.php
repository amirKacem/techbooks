<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

abstract  class BaseFixture extends Fixture{
    
    protected $faker;
    private $referencesIndex = [];

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);  
    }
    protected function createMany(string $classname, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $classname();
            $factory($entity, $i);

            $this->manager->persist($entity);
            
            $this->addReference(sprintf('%s_%d', $classname, $i), $entity);
        }
       
       
    }
     protected function getRandomReference(string $className) {
        if (!isset($this->referencesIndex[$className])) {
          
            $this->referencesIndex[$className] = [];
            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $className.'_') === 0) {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }
        if (empty($this->referencesIndex[$className])) {
            throw new \Exception(sprintf('Cannot find any references for class "%s"', $className));
        }
        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
        return $this->getReference($randomReferenceKey);
    }

}