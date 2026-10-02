<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | STAFF ID
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'staff_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('staff_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | CASHFREE ORDER ID
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'cashfree_order_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('cashfree_order_id')
                    ->nullable()
                    ->unique()
                    ->after('staff_id');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'payment_status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_status')
                    ->default('pending')
                    ->after('status');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'payment_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method')
                    ->nullable()
                    ->after('payment_status');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT ID
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'payment_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_id')
                    ->nullable()
                    ->after('payment_method');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | DELIVERED BY
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'delivered_by')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('delivered_by')
                    ->nullable()
                    ->after('payment_id');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | LATITUDE
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'latitude')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('latitude', 10, 7)
                    ->nullable()
                    ->after('phone');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | LONGITUDE
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('orders', 'longitude')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('longitude', 10, 7)
                    ->nullable()
                    ->after('latitude');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FEEDBACK PROMPT DISMISSED
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn(
            'orders',
            'feedback_prompt_dismissed_at'
        )) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp(
                    'feedback_prompt_dismissed_at'
                )->nullable()->after('longitude');
            });
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | We intentionally do not remove existing columns here.
        |--------------------------------------------------------------------------
        |
        | Some of these columns may have been created by earlier migrations.
        | Removing them could destroy existing production data.
        |
        */
    }
};
