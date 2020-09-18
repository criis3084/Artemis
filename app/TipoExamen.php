<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoExamen extends Model
{
	protected $fillable = ['nombre','estado'];

	public function examenes(){
		return $this->hasMany('App\Examen','tipo_examen_id','id');
	}
}
