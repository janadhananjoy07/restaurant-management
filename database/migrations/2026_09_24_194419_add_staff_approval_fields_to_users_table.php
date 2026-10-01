<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('staff_status')
                ->default('pending')
                ->after('role');

            $table->timestamp('staff_approved_at')
                ->nullable()
                ->after('staff_status');

            $table->text('staff_rejection_reason')
                ->nullable()
                ->after('staff_approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'staff_status',
                'staff_approved_at',
                'staff_rejection_reason',
            ]);
        });
    }
};
