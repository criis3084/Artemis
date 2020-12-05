<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEscuelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuelas', function (Blueprint $table) {
			$table->id();
			$table->string('nombre',100);
			$table->string('direccion');
			$table->boolean('estado')->default(1);
			$table->timestamps();
		});
		DB::table('escuelas')->insert(array(
			'nombre'=>'Sin Escuela',
			'direccion'=>'-----------'
		));	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escuelas');
    }
}
