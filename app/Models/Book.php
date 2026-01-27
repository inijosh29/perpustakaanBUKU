<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'title',
        'author',
        'category',
        'tahun',
        'stock',
        'image',
        'sinopsis',
    ];

    /**
     * Relationship: Book has many rentals
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}

}
