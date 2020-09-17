<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
	protected $fillable = ['nombre','aldea_id'];

	public function aldea(){
		return $this->belongsTo(aldea::class);
	}
	public function relaciones(){
		return $this->hasMany(Relacion::class);
	}
	public function personas(){
		return $this->hasMany(PersonaSinAcceso::class);
	}
}
