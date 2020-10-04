<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoVivienda extends Model
{
	protected $fillable = ['cantidad_abono','cantidad_restante','descripcion','fecha_pago','usuario_id','estado'];
	
	public function usuario(){
		return $this->belongsTo('App\Usuario','usuario_id','id');
	}
}
