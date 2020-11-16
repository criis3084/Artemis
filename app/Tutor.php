<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
	protected $fillable = ['especialidad','user_id','estado'];

	public function datos(){
		return $this->belongsTo('App\User','user_id','id');
	}
	public function tutorias(){
		return $this->hasMany('App\Tutoria','tutor_id','id');
	}
}
