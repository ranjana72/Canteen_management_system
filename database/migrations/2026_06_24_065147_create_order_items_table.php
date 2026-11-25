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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();                                                   // bigint unsigned, PK, AUTO
            $table->foreignId('order_id')                                   // bigint unsigned, FK, NOT NULL
                  ->constrained('orders')
                  ->cascadeOnDelete();
            $table->foreignId('menu_item_id')                               // bigint unsigned, FK, NOT NULL
                  ->constrained('menu_items')
                  ->restrictOnDelete();
            $table->integer('quantity');                                     // int, NOT NULL
            $table->decimal('unit_price', 8, 2);                            // decimal(8,2), NOT NULL - price at time of order
            $table->decimal('subtotal', 10, 2);                             // decimal(10,2), NOT NULL - quantity x unit_price
            $table->timestamps();                                            // created_at & updated_at (nullable timestamps)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};