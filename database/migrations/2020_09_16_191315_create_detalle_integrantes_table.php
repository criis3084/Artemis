<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleIntegrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_integrantes', function (Blueprint $table) {
            $table->id();
            $table->float('prestamo_individual',8,2);
			$table->foreignId('encargado_id')->constrained();
			$table->foreignId('grupo_prestamo_id')->constrained();
            $table->foreignId('destino_inversion_id')->constrained();
            $table->foreignId('microprestamo_id')->constrained();
			$table->boolean('estado')->default(1);
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_integrantes');
    }
}
