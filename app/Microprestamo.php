<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microprestamo extends Model
{
	protected $fillable = ['total','interes','fecha_inicio','duracion','dia_pago','mora_por_atraso','estado','destino_inversion_id'];

	public function destino(){
		return $this->belongsTo('App\DestinoInversion','destino_inversion_id','id');
	}
	public function abonos(){
		return $this->hasMany('App\AbonoPrestamo','microprestamo_id','id');
	}
}
