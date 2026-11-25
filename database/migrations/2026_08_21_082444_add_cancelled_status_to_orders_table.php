<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','ready','delivered','cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Any 'cancelled' rows must be reverted to 'pending' before shrinking the enum,
        // otherwise MySQL will reject the ALTER (or silently null/blank the column).
        DB::statement("UPDATE orders SET status = 'pending' WHERE status = 'cancelled'");
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','ready','delivered') NOT NULL DEFAULT 'pending'");
    }
};