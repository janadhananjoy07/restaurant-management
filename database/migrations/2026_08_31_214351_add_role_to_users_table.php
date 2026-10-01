<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // The role column already exists in the users table.
    }

    public function down(): void
    {
        // Nothing to rollback.
    }
};
