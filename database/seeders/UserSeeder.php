<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.local',
            'password' => Hash::make('password'),
        ]);

        $user->createToken('default');

        for($i = 2; $i <= 10; $i++) {
            echo "Creating User#$i\n";

            $user =User::create([
                'name' => 'Regular User ' . $i,
                'email' => $faker->email(),
                'password' => Hash::make('password'),
            ]);

            $user->createToken('default');
        }
    }
}
