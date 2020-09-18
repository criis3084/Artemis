<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
	protected $fillable = ['descripcion_puesto','usuario_id','estado'];

	public function datos(){
		return $this->belongsTo('App\Usuario','usuario_id','id');
	}
}
