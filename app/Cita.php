<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
	protected $fillable = ['fecha','descripcion','clinico_id','paciente_id','tipo_cita_id','estado'];

	public function clinico(){
		return $this->belongsTo('App\Clinico','clinico_id','id');
	}
	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
	}
	public function tipoCita(){
		return $this->belongsTo('App\TipoCita','tipo_cita_id','id');
	}
	public function datos_paciente(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Paciente',
			'id',
			'id',
			'paciente_id',
			'persona_sin_acceso_id'
		);
	}
	public function datos_clinico(){
		return $this->hasManyThrough(
			'App\Usuario',
			'App\Clinico',
			'id',
			'id',
			'clinico_id',
			'usuario_id'
		);
	}
}
