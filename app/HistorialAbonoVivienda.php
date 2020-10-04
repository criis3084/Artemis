<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialAbonoVivienda extends Model
{
    protected $fillable = ['abono_vivienda_id','vivienda_id','estado'];

	public function abono(){
		return $this->belongsTo('App\AbonoVivienda','abono_vivienda_id','id');
	}
	public function vivienda(){
		return $this->belongsTo('App\Vivienda','vivienda_id','id');
	}
}
