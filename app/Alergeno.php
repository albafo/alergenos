<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LanguageModel;

class Alergeno extends LanguageModel {

	public function ingredientes() {
	    return $this->belongsToMany('App\Ingrediente');
	}

}
