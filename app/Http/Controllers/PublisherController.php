<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function list()
    {
        $publishers = Publisher::all()->sortBy('name');
        $title = "الناشرون";

        return view('publishers.index', compact('publishers', 'title'));
    }

    public function search (Request $request)
    {
        $publishers = Publisher::where('name', 'LIKE', '%' . $request->term . '%')->paginate(12);
        $title = " عرض نتائج البحث عن" . " : " . $request->term;

        return view('publishers.index', compact('publishers', 'title'));
    }

    public function getByPublisher (Publisher $publisher) 
    {
        $books = $publisher->books()->paginate(12);
        $title = " عرض كتب الناشر " . " : " . $publisher->name;

        return view('gallery', compact('books', 'title'));
    }

    public function index()
    {
        $publishers = Publisher::all();

        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'address' => 'sometimes',            
        ]);

        Publisher::create($data);

        session()->flash('flash_message', 'تمت  إضافة الناشر بنجاح');
        return redirect(route('publishers.index'));
    }

    public function show(Publisher $publisher)
    {
        return view('admin.publishers.show', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }


    public function update(Request $request, Publisher $publisher)
    {
        $data = request()->validate([
            'name' => 'required',
            'address' => 'sometimes',            
        ]);

        $publisher->update($data);

        session()->flash('flash_message', 'تمت  تعديل بيانات الناشر بنجاح');
        return redirect(route('publishers.index'));
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        session()->flash('flash_message', 'تمت  حذف بيانات الناشر بنجاح');
        return redirect(route('publishers.index'));
    }
}
