<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
	protected $fillable = ['especialidad','usuario_id','estado'];

	public function informacion(){
		return $this->belongsTo(Usuario::class);
	}
	public function tutorias(){
		return $this->hasMany(Tutoria::class);
	}
}
