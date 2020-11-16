<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoVivienda extends Model
{
	protected $fillable = ['cantidad_abono','cantidad_restante','descripcion','fecha_pago','user_id','estado'];
	
	public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}
}
