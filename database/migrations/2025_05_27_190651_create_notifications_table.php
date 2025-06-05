<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Кому повідомлення
            $table->string('type'); // Тип сповіщення (наприклад: 'return_reminder', 'new_book', 'overdue_notice', 'general')
            $table->text('message'); // Текст повідомлення
            $table->boolean('is_read')->default(false); // Чи прочитано
            $table->timestamps();

            $table->index('user_id');
            $table->index('is_read');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
}
