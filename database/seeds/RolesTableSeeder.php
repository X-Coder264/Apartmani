<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role' => 'Admin',
        ]);

        Role::create([
            'role' => 'User',
        ]);

        Role::create([
            'role' => 'Client',
        ]);
    }
}
