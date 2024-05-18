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
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product')->unsigned()->nullable();
            $table->bigInteger('id_signa')->unsigned()->nullable();
            $table->bigInteger('id_order')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->nullable(false);
            $table->integer('price')->unsigned()->nullable(false);
            $table->integer('dosis')->nullable();
            $table->string('note', 255)->nullable();
            $table->string('note2', 255)->nullable();
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
        Schema::dropIfExists('detail_orders');
    }
};
