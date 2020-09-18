<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
	protected $fillable = ['especialidad','usuario_id','estado'];

	public function datos(){
		return $this->belongsTo('App\Usuario','usuario_id','id');
	}
	public function tutorias(){
		return $this->hasMany('App\Tutoria','tutor_id','id');
	}
}
