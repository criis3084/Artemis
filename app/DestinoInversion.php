<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinoInversion extends Model
{
	protected $fillable = ['nombre','estado'];

	/*public function microprestamos(){
		return $this->hasMany('App\Microprestamo','destino_inversion_id','id');
	}*/
	
	public function detalle(){
		return $this->hasMany('App\DetalleIntegrante','destino_inversion_id','id');
	}
}
