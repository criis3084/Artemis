<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
	protected $fillable = ['ruta_imagen','estado','persona_sin_acceso_id','escolaridad','ingresos','ocupacion'];

	public function datos(){
		return $this->belongsTo('App\PersonaSinAcceso','persona_sin_acceso_id','id');
	}
}
