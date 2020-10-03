<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apadrinamiento extends Model
{
	protected $fillable = ['nino_id','padrino_id','estado'];

	public function nino(){
		return $this->belongsTo('App\Nino','nino_id','id');
	}
/*
	public function padrino_persona(){
		return $this->belongsTo('App\PersonaSinAcceso','persona_sin_acceso_id',belongsTo('App\Padrino','padrino_id','id'));
	}
*/
	
	public function padrino(){
		return $this->belongsTo('App\Padrino','padrino_id','id');
	}

	public function datos_padrino(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Padrino',
			'id',
			'id',
			'padrino_id',
			'persona_sin_acceso_id'
		);
	}
	public function datos_nino(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Nino',
			'id',
			'id',
			'nino_id',
			'persona_sin_acceso_id'
		);
	}
	/*
	/*
	public function nino_sin_accesso(){
		return $this->belongsTo('App\Nino','nino_id','id');
	}
	*/
}
