<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LanguageModel;

/**
 * App\Alergeno
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $img
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ingrediente[] $ingredientes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Idioma[] $traduccion
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Alergeno whereUpdatedAt($value)
 */
class Alergeno extends LanguageModel {

	public function ingredientes() {
	    return $this->belongsToMany('App\Ingrediente');
	}

}
