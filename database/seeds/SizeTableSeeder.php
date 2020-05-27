<?php

use Illuminate\Database\Seeder;
use App\Size;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Size::create([
            'name' => 'Individual',
            'price' => 0,
        ]);
        Size::create([
            'name' => 'Medium',
            'price' => 2,
        ]);
        Size::create([
            'name' => 'Big',
            'price' => 4,
        ]);
    }
}
