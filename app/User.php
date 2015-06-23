<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\User
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellidos
 * @property string $tipo
 * @property string $email
 * @property string $password
 * @property boolean $status
 * @property boolean $confirmed
 * @property string $email_confirmation
 * @property string $icono_estb
 * @property string $direccion
 * @property string $telefono
 * @property string $nombre_establ
 * @property string $expired_at
 * @property string $remember_token
 * @property integer $activation_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereApellidos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmailConfirmation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIconoEstb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDireccion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTelefono($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNombreEstabl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereExpiredAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereActivationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usuarios';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 'nombre', 'apellidos', 'password', 'email_confirmation', 'nombre_establ'];
	protected $guarded = ['expired_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'email_confirmation'];

	public function toArray(){
		$array = parent::toArray();
        $array['DT_RowId'] = "row_".$this->id;
        return $array;
	}
    
    public function menus() {
        return $this->hasMany('App\Menu');
    }
    
    public function tickets() {
    	return $this->hasMany('App\Ticket');
    }
    
    public function platos($id_categoria=null) {
    	//\DB::connection()->enableQueryLog();

    	$platos=Plato::whereHas('categoria.menu.usuario', function($query) {
    		$query->where('user_id', '=', $this->id);
    	})->whereHas('categoria', function($query) use ($id_categoria) {
    		if($id_categoria)
    			$query->where('categoria','<>', $id_categoria);
    	})->get();
    	//$queries = \DB::getQueryLog();
    	return ($platos->sortBy('nombre'));
    	
    }

    public function getRandmonNumber($digits=4) {

        $min="";
        $max="";

        for($i = 0; $i < $digits; $i++) {
            $min.="1";
            $max.="9";
        }

        $min = intval($min);
        $max = intval($max);

        $number = rand($min, $max);

        return $number;
    }

    public function setRandomActivation() {

        $this->activation_code = $this->getRandmonNumber(6);
        $this->save();
        return $this->activation_code;


    }

    public function hasCompletedMenu()
    {
        foreach($this->menus as $menu) {
            $numPlatos=0;
            foreach($menu->categorias as $categoria) {
                foreach($categoria->platos as $plato) {
                    $numPlatos++;
                    if($numPlatos >= 5) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
