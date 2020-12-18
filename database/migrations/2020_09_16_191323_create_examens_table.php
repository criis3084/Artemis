<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examens', function (Blueprint $table) {
			$table->id();
			$table->string('descripcion')->nullable();
			$table->text('resultado')->nullable();
			$table->string('ruta_imagen')->nullable();
			$table->date('fecha_examen')->nullable();
			$table->foreignId('tipo_examen_id')->constrained();
			$table->foreignId('clinico_id')->constrained();
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
        Schema::dropIfExists('examens');
    }
}
