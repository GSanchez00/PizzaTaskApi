<?php

use Illuminate\Database\Seeder;
use App\Pizza;

class PizzaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Pizza::truncate();

        //$faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        
        Pizza::create([
            'name' => 'Pepperoni',
            'price' => 17,
        ]);

        Pizza::create([
            'name' => 'Chesse',
            'price' => 15,
        ]);

        Pizza::create([
            'name' => 'Tunna',
            'price' => 21,
        ]);

        Pizza::create([
            'name' => 'Chicken',
            'price' => 20,
        ]);

        Pizza::create([
            'name' => 'Four Cheese',
            'price' => 23,
        ]);

        Pizza::create([
            'name' => 'Fugazzeta',
            'price' => 22,
        ]);

        Pizza::create([
            'name' => 'Veggie',
            'price' => 20,
        ]);

        Pizza::create([
            'name' =>  'Neapolitan',
            'price' => 18,
        ]);

    }
}
