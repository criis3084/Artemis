<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nino extends Model
{
	protected $fillable = ['codigo','fecha_ingreso','fecha_egreso','ruta_imagen','estado','persona_sin_acceso_id','escuela_id','grado','ocupacion','actividades'];

	public function escuela(){
		return $this->belongsTo('App\Escuela','escuela_id','id');
	}

	public function datos(){
		return $this->belongsTo('App\PersonaSinAcceso','persona_sin_acceso_id','id');
	}

}
