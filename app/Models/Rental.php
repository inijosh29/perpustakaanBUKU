<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'rented_at',
        'returned_at',
        'status',
        'category',
    ];

    // CAST kolom tanggal ke Carbon
    protected $casts = [
        'rented_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
