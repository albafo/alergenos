<?php namespace App;

use App\LanguageModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categoria extends LanguageModel {

    use SoftDeletes;

	protected $guarded = ['id'];

	public function platos() {
        return $this->belongsToMany('App\Plato');
    }
    
    public function menu() {
        return $this->belongsTo('App\Menu');
    }



}
