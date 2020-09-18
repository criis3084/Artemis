<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutoria extends Model
{
	protected $fillable = ['nombre','fecha','estado','tutor_id','nino_id'];

	public function tutor(){
 		return $this->belongsTo('App\tutor','tutor_id','id');
	}

	public function nino(){
		return $this->belongsTo('App\Nino','nino_id','id');
	}


}
