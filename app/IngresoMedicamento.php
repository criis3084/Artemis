<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoMedicamento extends Model
{
	protected $fillable = ['fecha_ingreso','descripcion','usuario_id','proveedor_id','estado'];

	public function usuario(){
		return $this->belongsTo('App\Usuario','usuario_id','id');
	}
	public function proveedor(){
		return $this->belongsTo('App\Proveedor','proveedor_id','id');
	}
	public function detalleIngresos(){
		return $this->belongsTo('App\DetalleIngreso','detalle_ingreso_id','id');
	}
}
