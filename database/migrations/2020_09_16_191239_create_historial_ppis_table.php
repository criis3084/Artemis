<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialPpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_ppis', function (Blueprint $table) {
			$table->id();
			$table->date('fecha_estudio');
			$table->foreignId('nino_id')->constrained();
			$table->foreignId('ppi_id')->constrained();
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
        Schema::dropIfExists('historial_ppis');
    }
}
