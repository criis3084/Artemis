<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVivienda extends Model
{
	protected $fillable = ['nombre','descripcion','estado'];

	public function viviendas(){
		return $this->hasMany('App\Vivienda','tipo_vivienda_id','id');
	}
}
