<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all()->sortBy('name');
        $title = "المؤلفون";

        return view('authors.index', compact('authors', 'title'));
    }

    public function search (Request $request)
    {
        $authors = Author::where('name', 'LIKE', '%' . $request->term . '%')->paginate(12);
        $title = " عرض نتائج البحث عن" . " : " . $request->term;

        return view('authors.index', compact('authors', 'title'));
    }
    
    public function getByAuthor (Author $author)
    {
        $books = $author->books()->paginate(12);
        $title = " عرض كتب المؤلف " . " : " . $author->name;

        return view('gallery', compact('books', 'title'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Author $author)
    {
        //
    }

    public function edit(Author $author)
    {
        //
    }

    public function update(Request $request, Author $author)
    {
        //
    }

    public function destroy(Author $author)
    {
        //
    }
}