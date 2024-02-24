<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed pivot table book_category
        $php_category = Category::where('name', 'PHP')->first();
        $javascript_category = Category::where('name', 'Javascript')->first();
        $linux_category = Category::where('name', 'Linux')->first();
        $mysql_category = Category::where('name', 'MySQL')->first();

        $learning_php_mysql_javascript_book = Book::where('isbn', '978-1491918661')->first();
        $ubuntu_up_and_running_book = Book::where('isbn', '978-0596804848')->first();
        $linux_bible_book = Book::where('isbn', '978-1118999875')->first();
        $javascript_the_good_parts_book = Book::where('isbn', '978-0596517748')->first();

        // Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5 - has 2 categories (PHP, Javascript)
        BookCategory::create([
            'book_id' => $learning_php_mysql_javascript_book->id,
            'category_id' => $php_category->id,
        ]);
        BookCategory::create([
            'book_id' => $learning_php_mysql_javascript_book->id,
            'category_id' => $javascript_category->id,
        ]);

        // Ubuntu: Up and Running: A Power User's Desktop Guide - has Linux category
        BookCategory::create([
            'book_id' => $ubuntu_up_and_running_book->id,
            'category_id' => $linux_category->id,
        ]);

        // Linux Bible - has Linux category
        BookCategory::create([
            'book_id' => $linux_bible_book->id,
            'category_id' => $linux_category->id,
        ]);
        
        // JavaScript: The Good Parts - has Javascript category
        BookCategory::create([
            'book_id' => $javascript_the_good_parts_book->id,
            'category_id' => $javascript_category->id,
        ]);
    }
}
