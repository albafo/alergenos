<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Menu extends Model {

    use SoftDeletes;

	protected $guarded = ['id'];
    
    public function categorias() {
        return $this->hasMany('App\Categoria');
    }
    
    public function usuario() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function alergenos() {
       
        $c = new \Illuminate\Database\Eloquent\Collection;
        foreach($this->categorias as $categoria) {
            foreach($categoria->platos as $plato) {
                foreach($plato->ingredientes as $ingrediente) {
                    foreach($ingrediente->alergenos as $alergeno) {
                        $c->add($alergeno);
                    }
                }
            }
        }
        return $c->unique();        

    }

}
