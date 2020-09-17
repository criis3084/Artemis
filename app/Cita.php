<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
	protected $fillable = ['fecha','descripcion','clinico_id','paciente_id','tipo_cita_id','estado'];

	public function clinico(){
		return $this->belongsTo(Clinico::class);
	}
	public function paciente(){
		return $this->belongsTo(Paciente::class);
	}
	public function tipoCita(){
		return $this->belongsTo(TipoCita::class);
	}
}
