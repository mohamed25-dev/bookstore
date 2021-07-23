<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->administration_level > 0;
    }

    public function isSuperAdmin()
    {
        return $this->administration_level > 0;
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function rated(Book $book)
    {
        return $this->ratings->where('book_id', $book->id)->isNotEmpty();
    }

    public function bookRating(Book $book)
    {
        return $this->rated($book)
            ? $this->ratings->where('book_id', $book->id)->first()
            : NULL;
    }

    public function booksInCart ()
    {
        return $this->belongsToMany(Book::class)
            ->withPivot(['number_of_copies', 'bought'])
            ->wherePivot('bought', false);
    }

    public function purchasedBooks ()
    {
        return $this->belongsToMany(Book::class)
            ->withPivot('bought')
            ->wherePivot('bought', true);
    }
}
