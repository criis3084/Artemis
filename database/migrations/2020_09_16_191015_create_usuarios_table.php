<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('nombres',30);
			$table->string('apellidos',30);
			$table->string('CUI',15)->nullable();
			$table->boolean('genero');
			$table->string('numero_telefono',15)->nullable();
			$table->string('correo',50)->nullable();
			$table->string('direccion');
			$table->date('fecha_nacimiento');
			$table->string('imagen_perfil');
			$table->string('descripcion')->nullable();
			$table->boolean('estado')->default(1);
            $table->string('usuario')->unique();
            $table->string('password');
			$table->foreignId('rol_id')->constrained();
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
        Schema::dropIfExists('usuarios');
    }
}
