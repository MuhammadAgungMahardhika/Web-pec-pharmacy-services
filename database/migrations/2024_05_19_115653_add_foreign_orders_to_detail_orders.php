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
        Schema::table('detail_orders', function (Blueprint $table) {
            $table->foreign('id_order', 'fk_detail_order_order')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_orders', function (Blueprint $table) {
            $table->dropForeign('fk_detail_order_order');
        });
    }
};
