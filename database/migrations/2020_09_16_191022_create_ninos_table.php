<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ninos', function (Blueprint $table) {
			$table->id();
			$table->string('codigo',20);
			$table->date('fecha_ingreso');
			$table->date('fecha_egreso');
			$table->string('ruta_imagen');		
			$table->boolean('estado')->default(1);
			$table->foreignId('persona_sin_acceso_id')->constrained();
			$table->foreignId('escuela_id')->constrained();			
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
        Schema::dropIfExists('ninos');
    }
}
