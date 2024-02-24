<?php

namespace Database\Seeders;

use App\Models\Author;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed authors table
        $authors = [
            [
                'firstname' => 'Robin',
                'surname' => 'Nixon',
            ],
            [
                'firstname' => 'Christopher',
                'surname' => 'Negus',
            ],
            [
                'firstname' => 'Douglas',
                'surname' => 'Crockford',
            ],
        ];

        foreach ($authors as $author) {
            Author::create([
                'id' => Uuid::uuid(),
                'firstname' => $author['firstname'],
                'surname' => $author['surname'],
            ]);
        }
    }
}
