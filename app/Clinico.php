<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinico extends Model
{
	protected $fillable = ['profesion_id','usuario_id','estado'];

	public function informacion(){
		return $this->belongsTo(Usuario::class);
	}
	public function profesion(){
		return $this->belongsTo(Profesion::class);
	}
	public function consultas(){
		return $this->hasMany(HistorialClinico::class);
	}
}
