<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinico extends Model
{
	protected $fillable = ['profesion_id','usuario_id','estado'];

	public function informacion(){
		return $this->belongsTo('App\Usuario','usuario_id','id');
	}
	public function profesion(){
		return $this->belongsTo('App\Profesion','profesion_id','id');
	}
	public function consultas(){
		return $this->hasMany('App\HistorialClinico','clinico_id','id');
	}
}
