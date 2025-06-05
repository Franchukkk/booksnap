<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReservationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->timestamp('reserved_at')->useCurrent();
            $table->date('due_date')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->enum('status', ['reserved', 'borrowed', 'returned', 'overdue', 'cancelled'])->default('reserved');
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['book_id']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}
