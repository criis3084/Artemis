<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleBeneficio extends Model
{
	protected $fillable = ['cantidad','beneficio_id','medicamento_id','estado'];

	public function beneficio(){
		return $this->belongsTo(Beneficio::class);
	}
	public function medicamento(){
		return $this->belongsTo(Medicamento::class);
	}
}
