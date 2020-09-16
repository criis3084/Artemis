<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacions', function (Blueprint $table) {
			$table->id();
			$table->string('relacion');
			$table->string('direccion');
			$table->string('codigo',20);	
			$table->foreignId('nino_id')->constrained();
			$table->foreignId('encargado_id')->constrained();
			$table->foreignId('sector_id')->constrained();
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
        Schema::dropIfExists('relacions');
    }
}
