<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Interfaces\BookInterface;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index()
    {
        $books = Book::get();

        if ($books) {
            return response()->json($books, 200);
        } else {
            return response()->json('Resource not found', 404);
        }
    }

    /**
     * Filter books by author name
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchBookByAuthor(Request $request)
    {
        return $this->bookRepository->searchBookByAuthor($request);
    }

    /**
     * Get all categories
     *
     * @return JsonResponse|Response
     */
    public function getCategories()
    {
        return $this->bookRepository->getCategories();
    }

    /**
     * Filter books by category name
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchBookByCategory(Request $request)
    {
        return $this->bookRepository->searchBookByCategory($request);
    }

    /**
     * Filter books by author and category name
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function searchBookByAuthorAndCategory(Request $request)
    {
        return $this->bookRepository->searchBookByAuthorAndCategory($request);
    }

    /**
    * Store new book
    *
    * @param BookRequest $request
    * @return JsonResponse|Response
    */
    public function store(BookRequest $request)
    {
        return $this->bookRepository->store($request);
    }
}
