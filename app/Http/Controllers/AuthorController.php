<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function list()
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

    public function index()
    {
        $authors = Author::all();

        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'sometimes',            
        ]);

        Author::create($data);

        session()->flash('flash_message', 'تمت  إضافة المؤلف بنجاح');
        return redirect(route('authors.index'));
    }

    public function show(Author $author)
    {
        return view('admin.authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }


    public function update(Request $request, Author $author)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'sometimes',            
        ]);

        $author->update($data);

        session()->flash('flash_message', 'تمت  تعديل بيانات المؤلف بنجاح');
        return redirect(route('authors.index'));
    }

    public function destroy(Author $author)
    {
        $author->delete();

        session()->flash('flash_message', 'تمت  حذف بيانات المؤلف بنجاح');
        return redirect(route('authors.index'));
    }
}
