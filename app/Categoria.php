<?php namespace App;

use App\LanguageModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Categoria
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $menu_id
 * @property integer $orden
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plato[] $platos
 * @property-read \App\Menu $menu
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Idioma[] $traduccion
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereMenuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereOrden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categoria whereDeletedAt($value)
 */
class Categoria extends LanguageModel {

    use SoftDeletes;

	protected $guarded = ['id'];

	public function platos() {
        return $this->belongsToMany('App\Plato')->orderBy('orden', 'asc');
    }
    
    public function menu() {
        return $this->belongsTo('App\Menu');
    }



}
