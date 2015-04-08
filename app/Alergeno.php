<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Alergeno extends Model {

	public function ingredientes() {
	    return $this->belongsToMany('App\Ingrediente');
	}

}
