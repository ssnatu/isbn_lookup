<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first seed categories table
        $categories = [
            'PHP',
            'Javascript',
            'Linux',
        ];

        foreach ($categories as $category) {
            Category::create([
                'id' => Uuid::uuid(),
                'name' => $category
            ]);
        }
    }
}
