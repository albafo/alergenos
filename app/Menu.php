<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Menu
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $caducidad
 * @property float $precio
 * @property integer $user_id
 * @property boolean $estado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Categoria[] $categorias
 * @property-read \App\User $usuario
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereCaducidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu wherePrecio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereDeletedAt($value)
 */
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
