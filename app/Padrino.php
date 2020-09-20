<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padrino extends Model
{
	protected $fillable = ['ruta_imagen','correo','estado','persona_sin_acceso_id'];

	public function datos(){
		return $this->belongsTo('App\PersonaSinAcceso','persona_sin_acceso_id','id');
	}
	public function apadrinamiento(){
		return $this->hasMany('App\Apadrinamiento','padrino_id','id');
	}
}
