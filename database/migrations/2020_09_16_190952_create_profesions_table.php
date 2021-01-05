<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesions', function (Blueprint $table) {
			$table->id();
			$table->string('nombre',50);
			$table->boolean('estado')->default(1);
			$table->timestamps();
        });
        DB::table('profesions')->insert(array('nombre'=>'Enfermera'));
		DB::table('profesions')->insert(array('nombre'=>'Médico general'));
		DB::table('profesions')->insert(array('nombre'=>'Médico especialista'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesions');
    }
}
