<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456', ['rounds' => 15]),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'User',
            'email' => 'zdencec52@gmail.com',
            'password' => Hash::make('123456', ['rounds' => 15]),
            'role_id' => 2
        ]);

        Model::reguard();
    }
}
