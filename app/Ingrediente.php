<?php namespace App;

use \App\LanguageModel;

/**
 * App\Ingrediente
 *
 * @property integer $id
 * @property string $nombre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Alergeno[] $alergenos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plato')->withPivot("visible_home[] $plato
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $customAlergeno
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Idioma[] $traduccion
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ingrediente whereUpdatedAt($value)
 */
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


    public function hasCustomAlergeno($id_menu, $id_alergeno){

        return ! is_null(
            $this->customAlergeno()
                ->where('menu_id', $id_menu)
                ->where('alergeno_id', $id_alergeno)
                ->first()
        );
    }








}
