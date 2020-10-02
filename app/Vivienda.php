<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vivienda extends Model
{
	protected $fillable = ['costo_total','direccion','fecha_inicio','duracion','imagen_final','tipo_vivienda_id','constructor_id','encargado_id','estado'];

	public function tipoVivienda(){
		return $this->belongsTo('App\TipoVivienda','tipo_vivienda_id','id');
	}
	public function constructor(){
		return $this->belongsTo('App\Constructor','constructor_id','id');
	}
	public function datos_constructor(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Constructor',
			'id',
			'id',
			'constructor_id',
			'persona_sin_acceso_id'
		);
	}
	public function residente(){
		return $this->belongsTo('App\Encargado','encargado_id','id');
	}
	public function datos_residente(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Encargado',
			'id',
			'id',
			'encargado_id',
			'persona_sin_acceso_id'
		);
	}
	public function abonos(){
		return $this->hasMany('App\AbonoVivienda','vivienda_id','id');
	}
}
