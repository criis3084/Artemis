<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialExamen extends Model
{
	protected $fillable = ['notas','examen_id','paciente_id','estado'];

	public function examen(){
		return $this->belongsTo(Examen::class);
	}
	public function paciente(){
		return $this->belongsTo(Paciente::class);
	}
}
