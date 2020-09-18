<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
	protected $fillable = ['nombre','direccion','estado'];

	public function ninos(){
		return $this->hasMany('App\Nino','escuela_id','id');
	}
}
