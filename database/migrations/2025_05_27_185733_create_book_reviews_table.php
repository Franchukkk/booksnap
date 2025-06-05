<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReviewsTable extends Migration
{
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->comment('Оцінка від 1 до 5');
            $table->text('review')->nullable();
            $table->timestamps();

            $table->unique(['book_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
}
