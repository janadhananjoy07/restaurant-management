<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->nullable()
                ->unique()
                ->after('user_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->json('aspects')->nullable();
            $table->json('images')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('feedback_prompt_dismissed_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropUnique(['order_id']);
            $table->dropColumn([
                'order_id',
                'aspects',
                'images',
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('feedback_prompt_dismissed_at');
        });
    }
};