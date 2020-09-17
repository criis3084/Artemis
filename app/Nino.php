<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nino extends Model
{
	protected $fillable = ['codigo','fecha_ingreso','fecha_egreso','ruta_imagen','estado','persona_sin_acceso_id','escuela_id'];

	public function escuela(){
		return $this->belongsTo(Escuela::class);
	}
	public function informacion(){
		return $this->belongsTo(PersonaSinAcceso::class);
	}
}
