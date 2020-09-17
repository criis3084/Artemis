<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidaMedicamento extends Model
{
	protected $fillable = ['fecha_salida','descripcion','usuario_id','paciente_id','estado'];

	public function usuario(){
		return $this->belongsTo(Usuario::class);
	}
	public function paciente(){
		return $this->belongsTo(Paciente::class);
	}
	public function detalleSalida(){
		return $this->hasMany(DetalleSalida::class);
	}
}
