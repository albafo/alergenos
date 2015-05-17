<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categoria extends Model {

    use SoftDeletes;

	protected $guarded = ['id'];

	public function platos() {
        return $this->belongsToMany('App\Plato');
    }
    
    public function menu() {
        return $this->belongsTo('App\Menu');
    }
    



}
