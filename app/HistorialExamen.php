<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialExamen extends Model
{
	protected $fillable = ['examen_id','paciente_id','estado'];

	public function examen(){
		return $this->belongsTo('App\Examen','examen_id','id');
	}
	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
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
	public function tipo_examen(){
		return $this->hasManyThrough(
			'App\TipoExamen',
			'App\Examen',
			'id',
			'id',
			'examen_id',
			'tipo_examen_id'
		);
	}

	/*
	public function lista_examenes(){
		return $this->hasMany(Examen::class);
	}
	*/

}
