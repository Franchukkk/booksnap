<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'author',
        'genre',
        'type',
        'subject',
        'class_level',
        'is_recommended',
        'isbn',
        'description',
        'quantity',
        'cover_image',
    ];

    // Визначаємо зв'язок з моделлю School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Визначаємо зв'язок з моделлю Review
    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }
}
