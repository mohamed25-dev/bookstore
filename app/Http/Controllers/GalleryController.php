<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index ()
    {
        $books = Book::paginate(12);
        $title = "عرض الكتب حسب تاريخ الإضافة";

        return view('gallery', compact('books', 'title'));
    }
}
