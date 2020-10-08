<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{
	protected $fillable = ['relacion','direccion','codigo','nino_id','encargado_id','sector_id','estado'];

	public function nino(){
		return $this->belongsTo('App\Nino','nino_id','id');
	}
	public function encargado(){
		return $this->belongsTo('App\Encargado','encargado_id','id');
	}
	public function sector(){
		return $this->belongsTo('App\Sector','sector_id','id');
	}

	public function datos_nino(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\nino',
			'id',
			'id',
			'nino_id',
			'persona_sin_acceso_id'
		);
	}
	public function datos_encargado(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Encargado',
			'id',
			'id',
			'encargado_id',
			'persona_sin_acceso_id'
		);
	}

}
