<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialCorrespondencia extends Model
{
    /protected $fillable = ['correspondencia_id','apadrinamiento_id','estado'];

	public function correspondencia(){
		return $this->belongsTo('App\Correspondencia','correspondencia_id','id');
	}
	public function apadrinamiento(){
		return $this->belongsTo('App\Apadrinamiento','apadrinamiento_id','id');
	}
}
