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
        Schema::create('detail_purchases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product')->unsigned();
            $table->bigInteger('id_purchase')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('price')->unsigned();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_purchases');
    }
};
