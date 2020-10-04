<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonoViviendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_viviendas', function (Blueprint $table) {
			$table->id();
			$table->float('cantidad_abono',8,2);
			$table->string('descripcion');
			$table->date('fecha_pago');
			$table->float('cantidad_restante',8,2);
			$table->boolean('estado')->default(1);
			$table->foreignId('usuario_id')->constrained();
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
        Schema::dropIfExists('abono_viviendas');
    }
}
