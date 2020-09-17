<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padrino extends Model
{
	protected $fillable = ['ruta_imagen','correo','estado','persona_sin_acceso_id'];

	public function informacion(){
		return $this->belongsTo(PersonaSinAcceso::class);
	}
	public function apadrinamientos(){
		return $this->hasMany(Apadrinamiento::class);
	}
}
