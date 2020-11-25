<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('nombres',30);
			$table->string('apellidos',30);
			$table->string('CUI',15)->nullable();
			$table->boolean('genero');
			$table->string('numero_telefono',15)->nullable();
			$table->string('correo',50)->nullable();
			$table->string('direccion');
			$table->date('fecha_nacimiento');
			$table->string('imagen_perfil')->nullable();
			$table->string('descripcion')->nullable();
			$table->boolean('estado')->default(1);
            $table->string('user')->unique();
            $table->string('password');
			$table->foreignId('rol_id')->constrained();
			$table->timestamps();
		});

			DB::table('users')->insert(array(
			'nombres'=>'Juan','apellidos'=>'Simaj','genero'=>1,
			'direccion'=>'lejos','fecha_nacimiento'=>'1998-12-12',
			'imagen_perfil'=>null,'user'=>'juanS','password'=>Hash::make('123456'),
			'rol_id'=>1
			));
			DB::table('users')->insert(array(
			'nombres'=>'Maco','apellidos'=>'Rios','genero'=>1,
			'direccion'=>'lejos','fecha_nacimiento'=>'2000-11-11',
			'imagen_perfil'=>null,'user'=>'macorios','password'=>Hash::make('123456'),
			'rol_id'=>1
			));
			DB::table('users')->insert(array(
			'nombres'=>'Henry','apellidos'=>'Canastuj','genero'=>1,
			'direccion'=>'lejos','fecha_nacimiento'=>'2000-12-12',
			'imagen_perfil'=>null,'user'=>'henry','password'=>Hash::make('123456'),
			'rol_id'=>1
			));
			DB::table('users')->insert(array(
			'nombres'=>'Victor','apellidos'=>'Alvarado','genero'=>1,
			'direccion'=>'lejos','fecha_nacimiento'=>'2000-12-12',
			'imagen_perfil'=>null,'user'=>'victor','password'=>Hash::make('123456'),
			'rol_id'=>1
			));
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
