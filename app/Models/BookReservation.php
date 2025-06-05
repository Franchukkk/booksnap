<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'reserved_at',
        'due_date',
        'returned_at',
        'status',
    ];

    protected $dates = [
        'reserved_at',
        'due_date',
        'returned_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}