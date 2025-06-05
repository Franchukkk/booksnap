<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('genre')->nullable();
            $table->enum('type', ['textbook', 'non_textbook'])->default('non_textbook');
            $table->string('subject')->nullable();
            $table->string('class_level')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->string('isbn')->unique()->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
}
