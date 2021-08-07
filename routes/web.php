<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
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
Route::get('/categories', [CategoryController::class, 'list'])->name('gallery.categories.index');

Route::get('/publishers/search', [PublisherController::class, 'search'])->name('gallery.publishers.search');
Route::get('/publishers/{publisher}', [PublisherController::class, 'getByPublisher'])->name('gallery.publishers.show');
Route::get('/publishers', [PublisherController::class, 'list'])->name('gallery.publishers.index');

Route::get('/authors/search', [AuthorController::class, 'search'])->name('gallery.authors.search');
Route::get('/authors', [AuthorController::class, 'list'])->name('gallery.authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'getByAuthor'])->name('gallery.authors.show');

Route::get('/books/{book}', [BookController::class, 'details'])->name('book.details');
Route::post('/books/{book}/rate', [BookController::class, 'rate'])->name('book.rate');

Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view')->middleware('auth');
Route::post('/cart/removeOne/{book}', [CartController::class, 'removeOne'])->name('cart.removeOne')->middleware('auth');
Route::post('/cart/removeAll/{book}', [CartController::class, 'removeAll'])->name('cart.removeAll')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

Route::prefix('/admin')->middleware('can:update-books')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('users', UserController::class)->middleware('can:update-users');
});
