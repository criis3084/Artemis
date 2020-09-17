<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
	protected $fillable = ['nombre','descripcion','stock_general','estado','categoria_medicamento_id','casa_medica_id'];

	public function categoria(){
		return $this->belongsTo(CategoriaMedicamento::class);
	}
	public function casaMedica(){
		return $this->belongsTo(CasaMedica::class);
	}
	public function lotes(){
		return $this->hasMany(Lote::class);
	}
}
