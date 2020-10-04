<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialEstudio extends Model
{
    protected $fillable = ['estudio_socioeconomico_id','relacion_id','estado'];

	public function estudioSocieconomico(){
		return $this->belongsTo('App\EstudioSocioeconomico','estudio_socioeconomico_id','id');
	}
	public function relacion(){
		return $this->belongsTo('App\Relacion','relacion_id','id');
	}
	// public function datos_nino(){
	// 	return $this->hasManyThrough(
	// 		'App\PersonaSinAcceso',
	// 		'App\nino',
	// 		'id',
	// 		'id',
	// 		'nino_id',
	// 		'persona_sin_acceso_id'
	// 	);
    // }
    // public function datos_encargado(){
	// 	return $this->hasManyThrough(
	// 		'App\PersonaSinAcceso',
	// 		'App\Encargado',
	// 		'id',
	// 		'id',
	// 		'encargado_id',
	// 		'persona_sin_acceso_id'
	// 	);
	// }
}
