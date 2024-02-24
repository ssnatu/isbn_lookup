<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed books table
        $robin_nixon = Author::where('firstname', 'Robin')->where('surname', 'Nixon')->first();
        $christopher_negus = Author::where('firstname', 'Christopher')->where('surname', 'Negus')->first();
        $douglas_crockford = Author::where('firstname', 'Douglas')->where('surname', 'Crockford')->first();

        $books = [
            [
                'author_id' => $robin_nixon->id, //'author' => 'Robin Nixon',
                'isbn' => '978-1491918661',
                'title' => 'Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5',
                'price' => 9.99
            ],
            [
                'author_id' => $robin_nixon->id, //'author' => 'Robin Nixon',
                'isbn' => '978-0596804848',
                'title' => 'Ubuntu: Up and Running: A Power User\'s Desktop Guide',
                'price' => 12.99
            ],
            [
                'author_id' => $christopher_negus->id, //'author' => 'Christopher Negus',
                'isbn' => '978-1118999875',
                'title' => 'Linux Bible',
                'price' => 19.99
            ],
            [
                'author_id' => $douglas_crockford->id, //'author' => 'Douglas Crockford',
                'isbn' => '978-0596517748',
                'title' => 'JavaScript: The Good Parts',
                'price' => 8.99
            ],
        ];

        foreach ($books as $book) {
            Book::create([
                'id' => Uuid::uuid(),
                'author_id' => $book['author_id'],
                'isbn' => $book['isbn'],
                'title' => $book['title'],
                'price' => $book['price']
            ]);
        }
    }
}
