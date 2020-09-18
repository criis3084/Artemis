<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialExamen extends Model
{
	protected $fillable = ['notas','examen_id','paciente_id','estado'];

	public function examen(){
		return $this->belongsTo('App\Examen','examen_id','id');
	}
	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
	}
}
