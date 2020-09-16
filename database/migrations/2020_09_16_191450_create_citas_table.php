<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
			$table->id();
			$table->date('fecha');
			$table->string('descripcion');
			$table->boolean('estado')->default(1);
			$table->foreignId('clinico_id')->constrained();
			$table->foreignId('paciente_id')->constrained();
			$table->foreignId('tipo_cita_id')->constrained();
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
        Schema::dropIfExists('citas');
    }
}
