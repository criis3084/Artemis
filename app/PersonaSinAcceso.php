<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaSinAcceso extends Model
{
	// Confirmar si es hasOne o hasMany
	protected $fillable = ['nombres','apellidos','CUI','genero','fecha_nacimiento','direccion','numero_telefono','estado','sector_id'];
/*
	public function constructor(){
		return $this->hasMany(Constructor::class);
	}
	public function encargado(){
		return $this->hasMany(Constructor::class);
	}
	public function padrino(){
		return $this->hasMany(Padrino::class);
	}
	public function proveedor(){
		return $this->hasMany(Proveedor::class);
	}
	// probar si desde el sector se puede hacer un filtro por aldeas
	// Verificar las consultas medicas por codigos de la familia
	// maybe un hasOneThrough
	*/
	public function sector(){
		return $this->belongsTo('App\Sector','sector_id','id');		
	}
	public function nino(){
		// con esto tenemos el codigo del ni;o apadrinado
		return $this->hasOne('App\Nino','persona_sin_acceso_id','id');		
	}
}
