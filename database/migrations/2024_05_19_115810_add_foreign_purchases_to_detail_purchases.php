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
        Schema::table('detail_purchases', function (Blueprint $table) {
            $table->foreign('id_purchase', 'fk_detail_purchase_purchase')
                ->references('id')
                ->on('purchases')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_purchases', function (Blueprint $table) {
            $table->dropForeign('fk_detail_purchase_purchase');
        });
    }
};
