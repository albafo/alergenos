<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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

}
