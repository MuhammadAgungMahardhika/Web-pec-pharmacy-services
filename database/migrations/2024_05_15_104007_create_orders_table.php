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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_patient')->unsigned();
            $table->bigInteger('id_poli')->unsigned()->nullable(false);
            $table->string('id_doctor', 5)->nullable();
            $table->string('no_of_receipt', 5)->unique()->nullable(false);
            $table->date('date')->nullable(false);
            $table->date('date_of_service')->nullable(false);
            $table->enum('kind_of_medicine', ["Obat PRB", "Obat Kronis Blm Stabil", "Obat Kemoterapi"])->nullable(false);
            $table->integer('total_amount')->unsigned()->nullable(false);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->nullable(false);
            $table->string('bpjs_sep', 19)->nullable();
            $table->enum('bpjs_iteration', [0, 1])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
