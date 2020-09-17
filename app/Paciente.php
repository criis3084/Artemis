<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	protected $fillable = ['dia_apoyo','persona_sin_acceso_id','tipo_paciente_id','estado'];

	public function informacion(){
		return $this->belongsTo(PersonaSinAcceso::class);
	}
	public function tipoPaciente(){
		return $this->belongsTo(TipoPaciente::class);
	}
}
