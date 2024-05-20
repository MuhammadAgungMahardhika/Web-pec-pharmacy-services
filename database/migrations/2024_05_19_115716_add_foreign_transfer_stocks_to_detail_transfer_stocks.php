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
            $table->foreign('id_transfer_stock', 'fk_detail_transfer_stocks_transfer_stocks')
                ->references('id')
                ->on('transfer_stocks')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transfer_stocks', function (Blueprint $table) {
            $table->dropForeign('fk_detail_transfer_stocks_transfer_stocks');
        });
    }
};
