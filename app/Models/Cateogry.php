<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cateogry extends Model
{
    use HasFactory;

    public function books () 
    {
        return $this->hasMany(Book::class);
    }
}
