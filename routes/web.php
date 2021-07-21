<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/search', [GalleryController::class, 'search'])->name('search');

Route::get('/categories/search', [CategoryController::class, 'search'])->name('gallery.categories.search');
Route::get('/categories/{category}', [CategoryController::class, 'getByCategory'])->name('gallery.categories.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('gallery.categories.index');

Route::get('/publishers/search', [PublisherController::class, 'search'])->name('gallery.publishers.search');
Route::get('/publishers/{publisher}', [PublisherController::class, 'getByPublisher'])->name('gallery.publishers.show');
Route::get('/publishers', [PublisherController::class, 'index'])->name('gallery.publishers.index');

Route::get('/authors/search', [AuthorController::class, 'search'])->name('gallery.authors.search');
Route::get('/authors', [AuthorController::class, 'index'])->name('gallery.authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'getByAuthor'])->name('gallery.authors.show');

Route::get('/books/{book}', [BookController::class, 'details'])->name('book.details');



