<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();

            // Student who left the feedback
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Optional link to the order this feedback is about
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();

            // Optional link to a specific menu item (e.g. "Chicken Momo was delicious")
            $table->foreignId('menu_item_id')->nullable()->constrained()->nullOnDelete();

            // Star rating 1-5
            $table->unsignedTinyInteger('rating');

            // Optional written comment
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};