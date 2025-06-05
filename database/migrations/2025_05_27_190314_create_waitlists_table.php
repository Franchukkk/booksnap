<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitlistsTable extends Migration
{
    public function up(): void
    {
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('joined_at')->useCurrent(); // коли користувач став у чергу
            $table->boolean('notified')->default(false); // чи було повідомлення користувачу, що книга стала доступна
            $table->timestamps();

            $table->unique(['book_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
}
