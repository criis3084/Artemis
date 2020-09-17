<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constructor extends Model
{
	protected $fillable = ['estado','persona_sin_acceso_id'];

	public function informacion(){
		return $this->belongsTo(PersonaSinAcceso::class);
	}
	public function construcciones(){
		return $this->hasMany(Vivienda::class);
	}
}
