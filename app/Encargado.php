<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
	protected $fillable = ['ruta_imagen','estado','persona_sin_acceso_id'];

	public function informacion(){
		return $this->belongsTo(PersonaSinAcceso::class);
	}
}
