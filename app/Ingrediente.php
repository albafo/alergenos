<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model {
    
    
    public static function findByChar($char) {
      
        return Ingrediente::where('nombre', 'LIKE', $char.'%');
    }
    
    public static function findBySearch($search){
        return Ingrediente::where('nombre', 'LIKE', '%'.$search.'%');
    }
    
    public function alergenos() {
        
        return $this->belongsToMany('App\Alergeno');
    
    }
}
