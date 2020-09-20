<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPrestamo extends Model
{
	// Nombre del grupo
	protected $fillable = ['descripcion','cantidad_ultimo_prestamo','cantidad_prestamo_actual','estado'];

	public function integrantes(){
		return $this->hasMany('App\DetalleIntegrante','grupo_prestamo_id','id');
	}
}
