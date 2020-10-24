<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidaMedicamento extends Model
{
	protected $fillable = ['fecha_salida','tipo_salida','descripcion','usuario_id','paciente_id','estado'];

	public function usuario(){
		return $this->belongsTo('App\Usuario','usuario_id','id');
	}
	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
	}
	public function detalleSalida(){
		return $this->hasMany('App\DetalleSalida','salida_medicamento_id','id');
	}

	public function datos_persona(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Paciente',
			'id',
			'id',
			'paciente_id',
			'persona_sin_acceso_id'
		);
	}
}
