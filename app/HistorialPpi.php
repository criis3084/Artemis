<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialPpi extends Model
{

	protected $fillable = ['fecha_estudio','nino_id','ppi_id','estado'];

	public function nino(){
		return $this->belongsTo('App\Nino','nino_id','id');
	}
	public function ppi(){
		return $this->belongsTo('App\Ppi','ppi_id','id');
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
}
