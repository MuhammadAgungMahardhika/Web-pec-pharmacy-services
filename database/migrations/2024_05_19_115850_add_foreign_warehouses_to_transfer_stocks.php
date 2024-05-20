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
        Schema::table('transfer_stocks', function (Blueprint $table) {
            $table->foreign('id_warehouse', 'fk_transfer_stock_warehouse')
                ->references('id')
                ->on('warehouses')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfer_stocks', function (Blueprint $table) {
            $table->dropForeign('fk_transfer_stock_warehouse');
        });
    }
};
