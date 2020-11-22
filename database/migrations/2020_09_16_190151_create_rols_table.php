<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rols', function (Blueprint $table) {
			$table->id();
			$table->string('nombre',20);
			$table->boolean('estado')->default(1);
			$table->timestamps();
		});
		//1 = Directora
		//2 = Trabajadora social
		//3 = Secretaria
		//4 = Tutora
		//5 = Laboratorista
		//6 = Farmaceutica
		//7 = Medico 
		DB::table('rols')->insert(array('nombre'=>'Nombre'));
		DB::table('rols')->insert(array('nombre'=>'Trabajadora irectora'));
		DB::table('rols')->insert(array('nombre'=>'Secretaria'));
		DB::table('rols')->insert(array('nombre'=>'Tutora'));
		DB::table('rols')->insert(array('nombre'=>'Laboratorista'));
		DB::table('rols')->insert(array('nombre'=>'Farmaceutica'));
		DB::table('rols')->insert(array('nombre'=>'Medico'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rols');
    }
}
