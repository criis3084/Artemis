<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoMedicamento extends Model
{
	protected $fillable = ['fecha_ingreso','descripcion','usuario_id','proveedor_id','estado'];

	public function usuario(){
		return $this->belongsTo(Usuario::class);
	}
	public function proveedor(){
		return $this->belongsTo(Proveedor::class);
	}
	public function detalleIngresos(){
		return $this->hasMany(DetalleIngreso::class);
	}
}
