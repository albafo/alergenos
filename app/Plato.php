<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\LanguageModel;


/**
 * App\Plato
 *
 * @property integer $id
 * @property string $nombre
 * @property float $precio
 * @property integer $orden
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Categoria')->withPivot('precio[] $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ingrediente[] $ingredientes
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato wherePrecio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereOrden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plato whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Idioma[] $traduccion
 */
class Plato extends LanguageModel {
    
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

    public function customAlergenos($id_menu) {
        $c = array();
        foreach($this->ingredientes as $ingrediente) {
            $alergenos = \DB::table("custom_alergenos")->select("alergeno_id")->where("menu_id", "=", $id_menu)->where("ingrediente_id", "=", $ingrediente->id)->get();

            foreach($alergenos as $alergeno) {
                $c[] = Alergeno::find($alergeno->alergeno_id);
            }
        }


        return array_unique($c);
    }
    


    public function numIngVisibles() {
        $i=0;
        foreach($this->ingredientes as $ingrediente) {
            if($ingrediente->plato()->find($this->id)->pivot->visible_home) {
                $i++;
            }
        }
        return $i;
    }

    public function hasAlergeno($idAlergeno)
    {
        $alergenosPlato = $this->alergenos();
        foreach($alergenosPlato as $alergeno)
        {
            if($alergeno->id == $idAlergeno) {
                return true;
            }
        }
        return false;

    }
}
