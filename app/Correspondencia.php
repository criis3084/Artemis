<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correspondencia extends Model
{
	protected $fillable = ['mensaje','encabezado','piePagina','apadrinamiento_id','estado'];

	public function apadrinamiento(){
		return $this->belongsTo(Apadrinamiento::class);
	}
}
