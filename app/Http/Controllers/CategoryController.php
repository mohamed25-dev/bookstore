<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cateogry;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list()
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

    public function index ()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'sometimes',            
        ]);

        Category::create($data);

        session()->flash('flash_message', 'تمت  إضافة التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    public function show(Category $cateogry)
    {
        //
    }


    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'sometimes',            
        ]);

        $category->update($data);

        session()->flash('flash_message', 'تمت  تعديل التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        
        session()->flash('flash_message', 'تمت حذف التصنيف بنجاح');
        return redirect(route('categories.index'));
    }
}
