<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Unique reference generated BEFORE sending the user to eSewa,
            // used to match up the payment when eSewa redirects back.
            $table->string('transaction_uuid')->nullable()->unique()->after('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('transaction_uuid');
        });
    }
};