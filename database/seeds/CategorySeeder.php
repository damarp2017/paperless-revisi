<?php

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 6, 'prefix' => 'CAT-']),
            'name' => 'Makanan'
        ]);

        \App\Category::create([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 6, 'prefix' => 'CAT-']),
            'name' => 'Minuman'
        ]);

        \App\Category::create([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 6, 'prefix' => 'CAT-']),
            'name' => 'Elektronik'
        ]);

        \App\Category::create([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 6, 'prefix' => 'CAT-']),
            'name' => 'Jasa'
        ]);

        \App\Category::create([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 6, 'prefix' => 'CAT-']),
            'name' => 'Lainnya'
        ]);
    }
}
