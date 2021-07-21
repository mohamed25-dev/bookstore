<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Publisher $publisher)
    {
        //
    }

    public function edit(Publisher $publisher)
    {
        //
    }


    public function update(Request $request, Publisher $publisher)
    {
        //
    }

    public function destroy(Publisher $publisher)
    {
        //
    }
}
