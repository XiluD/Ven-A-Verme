<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('es_ES');
        // Create 50 product records
        for ($i = 0; $i < 8130; $i++) {
            Place::create([
                'provincia' => $faker->state,
                'municipio' => $faker->city,
                'codigoProvincia' => $faker->randomNumber(3),
                'codigoMunicipio' => $faker->randomNumber(3),
                'poblacion' => $faker->randomNumber(7),
                'imagenMuncipio' => $faker->image,
                'cAltitud' => $faker->randomFloat(4),
                'cLongitud' => $faker->randomFloat(4),
                'despoblacion' => $faker->boolean(50),
            ]);
        }
    }
}
