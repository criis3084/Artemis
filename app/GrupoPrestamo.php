<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPrestamo extends Model
{
	// Nombre del grupo
	protected $fillable = ['nombre','descripcion','cantidad_ultltimo_prestamo','cantidad_prestamo_actual','interes_uimo_prestamo','estado'] ;

	public function integrantes(){
		return $this->hasMany('App\DetalleIntegrante','grupo_prestamo_id','id');
	}
}
