<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $book = Book::find($request->id);
        $bookInCart = auth()->user()->booksInCart()->where('book_id', $book->id)->first();

        if ($bookInCart != null) {
            $newQty = $bookInCart->pivot->number_of_copies + $request->quantity;
            if ($newQty > $book->number_of_copies) {
                session()->flash('warning_message', 'العدد المتوفر أقل من المطلوب');
                return redirect()->back();
            }

            $bookInCart->pivot->number_of_copies = $newQty;
            $bookInCart->save();

            return redirect()->back();
        } else {
            auth()->user()->booksInCart()->attach(
                $book->id,
                ['number_of_copies' => $request->quantity]
            );
        }

        return redirect()->back();
    }

    public function viewCart()
    {
        $items = auth()->user()->booksInCart;
        return view('cart', compact('items'));
    }

    public function removeOne(Book $book)
    {
        $qty = auth()->user()->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies;

        if ($qty > 1) {
            auth()->user()->booksInCart()->updateExistingPivot(
                $book->id,
                ['number_of_copies' => --$qty]
            );
        } else {
            auth()->user()->booksInCart()->detach($book->id);
        }

        return redirect()->back();
    }

    public function removeAll(Book $book)
    {
        auth()->user()->booksInCart()->detach($book->id);
        return redirect()->back();
    }
}
