<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();                                                  // bigint unsigned, PK, AUTO
            $table->foreignId('user_id')                                   // bigint unsigned, FK, NOT NULL
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('order_number', 20)->unique();                  // varchar(20), NOT NULL, UNIQUE
            $table->enum('status', ['pending', 'confirmed', 'ready', 'delivered']); // enum, NOT NULL
            $table->timestamp('ready_at')->nullable();                     // timestamp, nullable
            $table->decimal('total_amount', 10, 2);                        // decimal(10,2), NOT NULL
            $table->text('note')->nullable();  
             $table->string('phone');                            // text, nullable
            $table->timestamps();                                          // created_at & updated_at (nullable timestamps)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};