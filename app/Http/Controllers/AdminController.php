<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index ()
    {
        $numberOfBooks = Book::count();
        $numberOfAuthors = Author::count();
        $numberOfPublishers = Publisher::count();
        $numberOfCategories = Category::count();

        return view('admin.index', compact(
            'numberOfBooks',
            'numberOfAuthors',
            'numberOfPublishers',
            'numberOfCategories'
        ));
    }
}
