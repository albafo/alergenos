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
    
    public function traduccion() {
    
        
            return $this->belongsToMany('App\Idioma', 'content_idiomas', 'content_id', 'idioma_id')
            ->withPivot('content')
            ->withPivot('table_name')
            ->wherePivot('table_name', '=', $this->getTable());
            
    }
    
    public function hasTraduccion($idioma_id) {
         return ! is_null(
        $this->traduccion()
             ->where('idioma_id', $idioma_id)
             ->first()
        );
    }


}
