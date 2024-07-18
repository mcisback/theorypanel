<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for($i = 1; $i <= 20; $i++) {
            echo "Creating Post#$i\n";

            Post::forceCreate([
                'message' => $faker->text(512),
                'user_id' => rand(1, 10),
            ]);
        }
    }
}
