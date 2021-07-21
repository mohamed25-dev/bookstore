<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index ()
    {
        $books = Book::paginate(12);
        $title = "عرض الكتب حسب تاريخ الإضافة";

        return view('gallery', compact('books', 'title'));
    }

    public function search (Request $request)
    {
        $books = Book::where('title', 'LIKE', '%' . $request->term . '%')->paginate(12);
        $title = " عرض نتائج البحث عن" . " : " . $request->term;

        return view('gallery', compact('books', 'title'));
    }

    public function getByCategory (Category $category)
    {
        $books = $category->books()->paginate(12);
        $title = " عرض الكتب بتصنيف " . " : " . $category->name;

        return view('gallery', compact('books', 'title'));
    }

    public function getByAuthor (Author $author)
    {
        $books = $author->books()->paginate(12);
        $title = " عرض كتب المؤلف " . " : " . $author->name;

        return view('gallery', compact('books', 'title'));
    }
}
