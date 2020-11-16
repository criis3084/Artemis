<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonoPrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_prestamos', function (Blueprint $table) {
			$table->id();
			$table->float('cantidad_abono',8,2);
			$table->float('cantidad_restante',8,2);
			$table->string('descripcion');
			$table->date('fecha_pago');
			$table->integer('mora')->default(0);
			$table->boolean('estado')->default(1);
			$table->foreignId('detalle_integrante_id')->constrained();
			$table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('abono_prestamos');
    }
}
