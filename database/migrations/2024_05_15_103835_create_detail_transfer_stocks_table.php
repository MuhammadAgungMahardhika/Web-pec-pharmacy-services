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
        Schema::create('detail_transfer_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product')->unsigned()->nullable();
            $table->bigInteger('id_transfer_stock')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->nullable(false);
            $table->integer('price')->unsigned()->nullable(false);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transfer_stocks');
    }
};
