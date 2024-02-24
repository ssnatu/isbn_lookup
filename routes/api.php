<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('getBooks', [BookController::class, 'index']);
Route::get('filter-books-by-author', [BookController::class, 'searchBookByAuthor']);
Route::get('categories', [BookController::class, 'getCategories']);
Route::get('filter-books-by-category', [BookController::class, 'searchBookByCategory']);
Route::get('filter-books-by-author-and-category', [BookController::class, 'searchBookByAuthorAndCategory']);
Route::post('books', [BookController::class, 'store']);
