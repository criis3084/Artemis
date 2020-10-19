<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicroprestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microprestamos', function (Blueprint $table) {
			$table->id();
			$table->float('total',8,2);
			$table->float('interes',8,2);
			$table->date('fecha_inicio');
			$table->tinyInteger('duracion');
            $table->date('dia_pago');
            $table->float('pago_mes');
			$table->integer('mora_por_atraso')->default(0);
			$table->tinyInteger('estado')->default(1);
			#$table->foreignId('destino_inversion_id')->constrained();
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
        Schema::dropIfExists('microprestamos');
    }
}
