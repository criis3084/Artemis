<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaSinAcceso extends Model
{
	protected $fillable = ['nombres','apellidos','CUI','genero','fecha_nacimiento','numero_telefono','estado'];

	public function constructor(){
		return $this->hasMany(Constructor::class);
	}
	public function encargado(){
		return $this->hasMany(Constructor::class);
	}
	public function nino(){
		// con esto tenemos el codigo del ni;o apadrinado
		return $this->hasMany(Constructor::class);
	}
	public function padrino(){
		return $this->hasMany(Padrino::class);
	}
	public function proveedor(){
		return $this->hasMany(Proveedor::class);
	}
	// probar si desde el sector se puede hacer un filtro por aldeas
	public function sector(){
		return $this->belongsTo(Proveedor::class);
	}
	// Verificar las consultas medicas por codigos de la familia
	// maybe un hasOneThrough
}
