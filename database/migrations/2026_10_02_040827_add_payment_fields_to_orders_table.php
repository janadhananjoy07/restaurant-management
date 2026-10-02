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
        Schema::table('orders', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | CASHFREE ORDER ID
            |--------------------------------------------------------------------------
            |
            | Stores Cashfree's order ID for this restaurant order.
            |
            */

            $table->string('cashfree_order_id')
                ->nullable()
                ->unique()
                ->after('id');


            /*
            |--------------------------------------------------------------------------
            | PAYMENT STATUS
            |--------------------------------------------------------------------------
            |
            | pending = payment not completed yet
            | paid    = payment successful
            | failed  = payment failed
            |
            */

            $table->string('payment_status')
                ->default('pending')
                ->after('status');


            /*
            |--------------------------------------------------------------------------
            | CASHFREE PAYMENT ID
            |--------------------------------------------------------------------------
            |
            | Stores Cashfree's payment identifier after
            | successful payment.
            |
            */

            $table->string('payment_id')
                ->nullable()
                ->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropUnique([
                'cashfree_order_id',
            ]);

            $table->dropColumn([
                'cashfree_order_id',
                'payment_status',
                'payment_id',
            ]);
        });
    }
};

