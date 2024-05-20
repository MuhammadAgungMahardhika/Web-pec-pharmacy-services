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
        Schema::table('detail_transfer_stocks', function (Blueprint $table) {
            $table->foreign('id_product', 'fk_detail_transfer_stock_product')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fk_detail_transfer_stock_product', function (Blueprint $table) {
            //
        });
    }
};
