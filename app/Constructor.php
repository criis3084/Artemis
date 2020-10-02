<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constructor extends Model
{
	protected $fillable = ['estado','persona_sin_acceso_id'];

	public function datos(){
		return $this->belongsTo('App\PersonaSinAcceso','persona_sin_acceso_id','id');
	}
	public function construcciones(){
		return $this->hasMany('App\Vivienda','constructor_id','id');
	}
}
