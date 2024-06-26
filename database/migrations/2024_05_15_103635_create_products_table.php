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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_unit')->unsigned()->nullable();
            $table->bigInteger('id_category')->unsigned()->nullable();
            $table->string('code', 20);
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->integer('price')->nullable()->default(0);
            $table->integer('stock_quantity');
            $table->date('expired')->nullable();
            $table->string('restriction', 255)->nullable();
            $table->boolean('bpjs_prb', 255)->nullable();
            $table->boolean('chronic', 255)->nullable();
            $table->boolean('chemo', 255)->nullable();
            $table->string('generic', 255)->nullable();
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
        Schema::dropIfExists('products');
    }
};
