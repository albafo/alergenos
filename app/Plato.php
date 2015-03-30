<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Plato extends Model {
    
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public function categoria() {
        return $this->belongsTo('App\Categoria');
    }
    
    public function ingredientes() {
        return $this->belongsToMany('App\Ingrediente');
    }

}
