<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppis', function (Blueprint $table) {
			$table->id();
			$table->tinyInteger('respuesta1');
			$table->tinyInteger('respuesta2');
			$table->tinyInteger('respuesta3');
			$table->tinyInteger('respuesta4');
			$table->tinyInteger('respuesta5');
			$table->tinyInteger('respuesta6');
			$table->tinyInteger('respuesta7');
			$table->tinyInteger('respuesta8');
			$table->tinyInteger('respuesta9');
			$table->tinyInteger('respuesta10');
			$table->integer('total');
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
        Schema::dropIfExists('ppis');
    }
}
