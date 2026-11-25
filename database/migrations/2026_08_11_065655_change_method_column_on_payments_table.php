<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Was a restrictive ENUM (e.g. 'cash','online') which silently
            // truncated any value not in the list (like 'esewa'). Widening
            // to a plain string avoids this for any future payment method.
            $table->string('method', 50)->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('method', ['cash', 'online'])->change();
        });
    }
};