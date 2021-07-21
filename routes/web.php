<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/search', [GalleryController::class, 'search'])->name('search');
Route::get('/categories/{category}', [GalleryController::class, 'getByCategory'])->name('gallery.categories.show');
Route::get('/authors/{author}', [GalleryController::class, 'getByAuthor'])->name('gallery.authors.show');

Route::get('/books/{book}', [BookController::class, 'details'])->name('book.details');



