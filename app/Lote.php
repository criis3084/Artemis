<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
	protected $fillable = ['stock','fecha_expiracion','numero_referencia','medicamento_id','estado'];

	public function medicamento(){
		return $this->belongsTo(Medicamento::class);
	}
	public function lotes(){
		return $this->hasMany(Lote::class);
	}
}
