<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();

        return view('admin.books.create', compact('authors', 'publishers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'isbn' => ['required', 'alpha_num', 'unique:books'],
            'cover_image' => ['image', 'required'],
            'category_id' => 'nullable',
            'authors' => 'nullable',
            'publisher_id' => 'nullable',
            'description' => 'nullable',
            'publish_year' => 'numeric|nullable',
            'number_of_pages' => 'numeric|required',
            'number_of_copies' => 'numeric|required',
            'price' => 'numeric|required',
        ]);

        $data['cover_image'] = $this->uploadImage($request->cover_image);

        $book = Book::create($data);
        $book->authors()->attach($request->authors);

        session()->flash('flash_message', 'تمت إضافة الكتاب بنجاح');

        return redirect(route('books.show', $book));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();

        return view('admin.books.edit', compact('authors', 'publishers', 'categories', 'book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = request()->validate([
            'title' => 'required',
            'isbn' => ['required', 'alpha_num', Rule::unique('books')->ignore($book->id)],
            'category_id' => 'nullable',
            'authors' => 'nullable',
            'publisher_id' => 'nullable',
            'description' => 'nullable',
            'publish_year' => 'numeric|nullable',
            'number_of_pages' => 'numeric|required',
            'number_of_copies' => 'numeric|required',
            'price' => 'numeric|required',
        ]);

        if (request()->hasFile('cover_image')) 
        {
            Storage::disk('public')->delete($book->cover_image);
            $data['cover_image'] = $this->uploadImage($request->cover_image);
        }


        $book->update($data);
        $book->authors()->sync($request->authors);

        session()->flash('flash_message', 'تمت تعديل بيانات الكتاب بنجاح');

        return redirect(route('books.show', $book));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Storage::disk('public')->delete($book->cover_image);
        $book->delete();
        
        session()->flash('flash_message', 'تمت حذف الكتاب بنجاح');
        return redirect(route('books.index'));
    }

    public function details(Book $book)
    {
        $purchased = 0;
        if (Auth::check()) {
            $boughtBook = auth()->user()->purchasedBooks()->where('book_id', $book->id)->first();
            if ($boughtBook) {
                $purchased = $boughtBook->pivot->bought;
            }
        }

        return view('books.details', compact('book', 'purchased'));
    }

    public function rate(Request $request, Book $book)
    {
        if (auth()->user()->rated($book)) {
            Rating::where(['user_id' => auth()->id(), 'book_id' => $book->id])
                ->update(['value' => $request->value]);
        } else {
            $book->ratings()
                ->create(['user_id' => auth()->id(), 'value' => $request->value]);
        }

        return back();
    }
}
