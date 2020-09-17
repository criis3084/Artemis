<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
	protected $fillable = ['descripcion','paciente_id','estado'];

	public function paciente(){
		return $this->belongsTo(Paciente::class);
	}
	public function beneficios(){
		return $this->hasMany(DetalleBeneficio::class);
	}
}