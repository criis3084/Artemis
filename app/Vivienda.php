<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vivienda extends Model
{
	protected $fillable = ['costo_total','direccion','fecha_inicio','duracion','imagen_final','tipo_vivienda_id','constructor_id','encargado_id','estado'];

	public function tipoVivienda(){
		return $this->belongsTo(TipoVivienda::class);
	}
	public function constructor(){
		return $this->belongsTo(Constructor::class);
	}
	public function residente(){
		return $this->belongsTo(Encargado::class);
	}
	public function abonos(){
		return $this->hasMany(AbonoVivienda::class);
	}
}
