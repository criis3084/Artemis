<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleBeneficio extends Model
{
	protected $fillable = ['cantidad','beneficio_id','medicamento_id','estado'];

	public function beneficio(){
		return $this->belongsTo('App\Beneficio','beneficio_id','id');
	}
	public function medicamento(){
		return $this->belongsTo('App\Medicamento','medicamento_id','id');
	}
}
