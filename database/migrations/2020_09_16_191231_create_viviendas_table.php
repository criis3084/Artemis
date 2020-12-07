<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViviendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viviendas', function (Blueprint $table) {
			$table->id();
			$table->integer('costo_total');
            $table->string('direccion');
            $table->string('donante');	
			$table->date('fecha_inicio');
			$table->tinyInteger('duracion');	
			$table->string('imagen_final')->nullable();	
			$table->foreignId('tipo_vivienda_id')->constrained();
			$table->foreignId('constructor_id')->constrained();
			$table->foreignId('encargado_id')->constrained();
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
        Schema::dropIfExists('viviendas');
    }
}
