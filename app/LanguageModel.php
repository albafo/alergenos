<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 17/05/15
 * Time: 22:27
 */

namespace app;

use Illuminate\Database\Eloquent\Model;



class LanguageModel extends Model{

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