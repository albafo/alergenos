<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Plato extends Model {
    
    use SoftDeletes;
    
    protected $guarded = ['id'];
    private static $alergenosCol;

    public function categoria() {
        return $this->belongsToMany('App\Categoria')->withPivot('precio');
    }
    
    public function ingredientes() {
        return $this->belongsToMany('App\Ingrediente');
    }
    
    public function alergenos() {
       
        $c = new \Illuminate\Database\Eloquent\Collection;

        foreach($this->ingredientes as $ingrediente) {
            foreach($ingrediente->alergenos as $alergeno) {
                $c->add($alergeno);
            }
        }
        return $c->unique();        

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
