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
        Schema::table('warehouse_stocks', function (Blueprint $table) {
            $table->foreign('id_warehouse', 'fk_warehouse_stocks_warehouse')
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
        Schema::table('warehouse_stocks', function (Blueprint $table) {
            $table->dropForeign('fk_warehouse_stocks_warehouse');
        });
    }
};
