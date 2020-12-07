<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
			$table->id();
			$table->string('nombre');
			$table->foreignId('aldea_id')->constrained();
			$table->boolean('estado')->default(1);
			$table->timestamps();
		});
		DB::table('sectors')->insert(array(
			'nombre'=>'Externo',
			'aldea_id'=>1,
		));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sectors');
    }
}
