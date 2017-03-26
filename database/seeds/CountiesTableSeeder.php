<?php

use App\County;
use Illuminate\Database\Seeder;

class CountiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        County::create([
            'name' => 'Istarska'
        ]);

        County::create([
            'name' => 'Zagrebačka'
        ]);
    }
}
