<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVivienda extends Model
{
	protected $fillable = ['nombre','descripcion','estado'];

	public function viviendas(){
		return $this->hasMany(Vivienda::class);
	}
}
