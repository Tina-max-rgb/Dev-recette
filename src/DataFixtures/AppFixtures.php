<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use App\Entity\Recette;
use Faker\Factory;

class AppFixtures extends Fixture {

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load (ObjectManager $manager): void
    {
        /*ingredients*/
        for ($i = 0; $i < 50; $i++){
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word()) 
                       ->setPrix(mt_rand(0, 100));
                       $ingredients[] = $ingredient;
                       $manager->persist($ingredient); 
                       $manager->flush();
           }


        /*Recettes*/
        for ($j = 0; $j < 25; $j++){
            $recette = new Recette();
            $recette->setName($this->faker->word()) 
                       ->setPrix(mt_rand(0, 100))
                       ->setTime(mt_rand(0, 1)== 1 ? mt_rand(1, 1440) : null)
                        ->setNbpersonne(mt_rand(0, 1) ==1 ? mt_rand(1, 51) : null)
                        ->setDifficulty(mt_rand(0, 1) ==1 ? mt_rand(1, 6): null)
                        ->setDescription($this->faker->text(300))
                        ->setIsFavorite(mt_rand(0, 1)==1 ? true:false)
                        ->setPrix(mt_rand (0, 1) == 1 ? mt_rand(1, 1000):null);


        for($k = 0; $k < mt_rand(5, 15); $k++){
                $recette->addIngredientsL ($ingredients[mt_rand (0,count ($ingredients) -1)]);
        }
                       $manager->persist($recette);  
                       $manager->flush();
    }
}

}