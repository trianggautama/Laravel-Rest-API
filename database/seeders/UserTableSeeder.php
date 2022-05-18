<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'John Doe',
            'email'     => 'johnExample@gmail.com',
            'password'  => bcrypt('password')
        ]);

        $user->createToken('JohnDoe')->plainTextToken;

        User::factory()->count(5)->create();
    }
}
