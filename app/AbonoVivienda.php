<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoVivienda extends Model
{
	protected $fillable = ['cantidad_abono','cantidad_restante','descripcion','fecha_pago','vivienda_id','usuario_id','estado'];

	public function vivienda(){
		return $this->belongsTo(Vivienda::class);
	}
	public function usuario(){
		return $this->belongsTo(Usuario::class);
	}
}
