<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
	protected $fillable = ['descripcion','peso_actual','glicemia','semanas_embarazo','talla','pulso','respiracion','temperatura','presion_arterial','objetivo','subjetivo','paciente_id','clinico_id','estado'];

	public function clinico(){
		return $this->belongsTo(Clinico::class);
	}
	public function paciente(){
		return $this->belongsTo(Paciente::class);
	}
}
