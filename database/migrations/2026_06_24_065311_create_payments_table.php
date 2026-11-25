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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();                                                   // bigint unsigned, PK, AUTO
            $table->foreignId('order_id')                                   // bigint unsigned, FK, NOT NULL
                  ->constrained('orders')
                  ->cascadeOnDelete();
            $table->foreignId('user_id')                                    // bigint unsigned, FK, NOT NULL
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->decimal('amount', 10, 2);                               // decimal(10,2), NOT NULL
            $table->enum('method', ['cash', 'online']);                     // enum, NOT NULL
            $table->enum('status', ['pending', 'paid', 'failed']);          // enum, NOT NULL
            $table->string('transaction_id', 100)->nullable();              // varchar(100), nullable
            $table->timestamp('paid_at')->nullable();                       // timestamp, nullable
            $table->timestamps();                                            // created_at & updated_at (nullable timestamps)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
