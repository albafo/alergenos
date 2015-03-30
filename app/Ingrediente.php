<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model {
    
    public static function findByChar($char) {
      
        return Ingrediente::where('nombre', 'LIKE', $char.'%');
    }
}
