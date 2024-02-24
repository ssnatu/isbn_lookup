<?php

namespace App\Repositories;

use App\Interfaces\BookInterface;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;

class BookRepository implements BookInterface
{
    /**
     * Filter books by author name
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchBookByAuthor($request)
    {
        $author = Author::with(['books' => function ($query){
            $query->select('author_id', 'isbn');
        }])
        ->whereRaw('LOWER(`firstname`) = ?', trim(strtolower($request->firstname))) // trim() - strip any spaces or other characters from beginning and end of the string
        ->whereRaw('LOWER(`surname`) = ?', trim(strtolower($request->surname)))
        ->first();

        if ($author) {
            $books = $author->books;
            if (count($books)) {
                foreach ($books as $book) {
                    unset($book->author_id); // response should contain only isbn column, so unset author_id
                }
                return response()->json($books, 200);
            } else {
                return response()->json('Resource not found', 404);
            }
        } else {
            return response()->json('Author not found', 404);
        }
    }

    /**
     * Get all categories
     *
     * @return JsonResponse|Response
     */
    public function getCategories()
    {
        $categories = Category::get(['name']); // select name column

        if (count($categories)) {
            $result = [];
            foreach ($categories as $category) {
                array_push($result, $category->name);
            }
            return response()->json($result, 200);
        } else {
            return response()->json('Resource not found', 404);
        }
    }

    /**
     * Filter books by category name
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchBookByCategory($request)
    {
        $category = strtolower(trim($request->name));

        if ($category) {
            // get books with category
            $books = Book::whereHas('categories', function($query) use ($category) {
                $query->where('name', '=', $category);
            })->get(['author_id', 'isbn']);

            if (count($books)) {
                foreach ($books as $book) {
                    unset($book->author_id); // response should contain only isbn column, so unset author_id
                }
                return response()->json($books, 200);
            } else {
                return response()->json('Resource not found', 404);
            }
        } else {
            return response()->json('Category not found', 404);
        }
    }

    /**
     * Filter books by author and category name
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchBookByAuthorAndCategory($request)
    {
        $firstname = strtolower(trim($request->firstname));
        $surname = strtolower(trim($request->surname));
        $category = strtolower(trim($request->category));

        // retrieve book which has a category = Linux and author = Robin Nixon
        $book = Book::whereHas('categories', function($query) use ($category) {
            $query->where('name', '=', $category);
        })
        ->whereHas('author', function($q) use($firstname, $surname) {
            $q->whereRaw('LOWER(`firstname`) = ?', $firstname)->whereRaw('LOWER(`surname`) = ?', $surname);
        })
        ->first(['author_id', 'isbn']);

        if ($book) {
            unset($book->author_id);
            return response()->json($book, 200);
        } else {
            return response()->json('Resource not found', 404);
        }
    }

    /** Store new book
    *
    * @param BookRequest $request
    * @return JsonResponse|Response
    */
    public function store($request)
    {
        // first check if book already exists
        $book = Book::where('isbn', '=', $request->input('isbn'))->first();
        if ($book) {
            return response()->json('ISBN already in use', 400);
        } else {
            // create author
            $authorData = [
                'firstname' => $request->input('author_firstname'),
                'surname' => $request->input('author_surname'),
            ];

            $author = Author::where('firstname', '=', $request->input('author_firstname'))
                    ->where('surname', '=', $request->input('author_surname'))
                    ->first();

            if (!$author) {
                $author = new Author($authorData);
                $author->save();
            }

            $bookData = [
                'author_id' => $author->id,
                'isbn' => $request->input('isbn'),
                'title' => $request->input('title'),
                'price' => $request->input('price')
            ];

            $book = new Book($bookData);
            $book->save();

            $category = Category::where('name', '=', $request->input('category'))->first();

            if (!$category) {
                $category = new Category(['name' => $category]);
                $category->save();
            }

            // update pivot table book_category
            $pivotData = [
                'book_id' => $book->id,
                'category_id' => $category->id,
            ];

            $pivot = new BookCategory($pivotData);
            $pivot->save();            

            // response
            $response = [
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $author->firstname . ' ' . $author->surname,
                'category' => $category->name,
                'price' => $book->price,
            ];

            return response()->json($response, 201);
        }
    }
}