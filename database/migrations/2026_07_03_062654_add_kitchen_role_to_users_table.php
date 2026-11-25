<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add 'kitchen' to the role enum in users table.
     * Run: php artisan migrate
     */
    public function up(): void
    {
        // MySQL requires redefining the full enum to add a new value
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'student', 'kitchen') NOT NULL");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'student') NOT NULL");
    }
};