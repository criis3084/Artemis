<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAldeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aldeas', function (Blueprint $table) {
			$table->id();
			$table->string('nombre');
			$table->boolean('estado')->default(1);
			$table->timestamps();
		});
		DB::table('aldeas')->insert(array(
			'nombre'=>'Externo'
		));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aldeas');
    }
}
