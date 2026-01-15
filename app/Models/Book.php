<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
     protected $fillable = ['title','author','stock', 'category','tahun',];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
