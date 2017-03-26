<?php

use App\Apartment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Apartment::create([
            'name' => 'Apartman 1',
            'user_id' => 1,
            'county_id' => 2,
            'stars' => 3,
            'description' => 'Najbolji apartman za ovu cijenu.',
            'price' => 200,
            'currency' => 'HRK'
        ]);

        Apartment::create([
            'name' => 'Apartman 2',
            'user_id' => 2,
            'county_id' => 1,
            'stars' => 5,
            'description' => 'Najbolji apartman u državi.',
            'price' => 500,
            'currency' => 'EUR'
        ]);

        factory(App\Apartment::class, 50)->create();

        Model::reguard();
    }
}
