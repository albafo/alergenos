<?php namespace App;

use \App\LanguageModel;

class Ingrediente extends LanguageModel {
    
    
    public static function findByChar($char) {
      
        return Ingrediente::where('nombre', 'LIKE', $char.'%');
    }
    
    public static function findBySearch($search){
        return Ingrediente::where('nombre', 'LIKE', '%'.$search.'%');
    }
    
    public function alergenos() {
        
        return $this->belongsToMany('App\Alergeno');
    
    }
    
    public function plato() {
        return $this->belongsToMany('App\Plato')->withPivot("visible_home");
    }

    public function customAlergeno() {

        return $this->belongsToMany('App\Menu', 'custom_alergenos')
            ->withPivot("alergeno_id");
    }


    public function hasCustomAlergeno($id_menu){
        return ! is_null(
            $this->customAlergeno()
                ->where('menu_id', $id_menu)
                ->first()
        );
    }








}
