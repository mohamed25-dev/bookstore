<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cateogry;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()->sortBy('name');
        $title = "التصنيفات";

        return view('categories.index', compact('categories', 'title'));
    }

    public function search (Request $request)
    {
        $categories = Category::where('name', 'LIKE', '%' . $request->term . '%')->paginate(12);
        $title = " عرض نتائج البحث عن" . " : " . $request->term;

        return view('categories.index', compact('categories', 'title'));
    }

    public function getByCategory (Category $category)
    {
        $books = $category->books()->paginate(12);
        $title = " عرض الكتب بتصنيف " . " : " . $category->name;

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

    public function show(Category $cateogry)
    {
        //
    }


    public function edit(Category $cateogry)
    {
        //
    }

    public function update(Request $request, Category $cateogry)
    {
        //
    }

    public function destroy(Category $cateogry)
    {
        //
    }
}
