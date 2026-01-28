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

    /**
     * Relationship: Book has many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * AVAILABLE STOCK (DINAMIS)
     * pending & rented = stok TERPAKAI
     */
    public function getAvailableStockAttribute()
    {
        $used = $this->rentals()
            ->whereIn('status', ['pending', 'rented'])
            ->count();

        return max(0, $this->stock - $used);
    }

    /**
     * Apakah buku sudah tidak bisa dirent
     */
    public function getIsUnavailableAttribute()
    {
        return $this->available_stock <= 0;
    }

    /**
     * Label status buku untuk UI
     */
    public function getRentalStatusLabelAttribute()
    {
        if ($this->rentals()->where('status', 'pending')->exists()) {
            return 'Sedang diproses';
        }

        if ($this->rentals()->where('status', 'rented')->exists()) {
            return 'Sedang dipinjam';
        }

        return 'Tersedia';
    }
}
