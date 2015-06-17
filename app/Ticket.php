<?php namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Ticket
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $peticion
 * @property integer $user_id
 * @property boolean $leido
 * @property boolean $resuelto
 * @property-read \App\User $usuarios
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket wherePeticion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereLeido($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereResuelto($value)
 */
class Ticket extends Model {

	public function usuarios() {
	    return $this->belongsTo('App\User', 'user_id');
	}

    public static function noReaded() {
        //\DB::connection()->enableQueryLog();
        $count = Ticket::where('leido', '=', 0)->count();
        
        //dd(\DB::getQueryLog());

        return $count;
    }
    
    public function toArray(){
		$array = parent::toArray();
        $array['DT_RowId'] = "row_".$this->id;
        return $array;
	}

    public function save(array $options = array())
    {
        $emailUser=$this->usuarios->email;

        $data = [

            'fecha'=>date("d/M/Y H:i", time()),
            'nombre_usuario'=>$this->usuarios->nombre,
            'email_usuario'=>$emailUser,
            'descripcion'=>$this->peticion

        ];
        \Mail::send('mail.newTicket', ['data'=>$data], function($msg) use ($emailUser) {


            $firstAdmin=User::whereTipo("admin")->first();
            $msg->to($firstAdmin->email, $firstAdmin->nombre);
            $msg->from('web@alergias-hosteleria.com', '');
            $msg->replyTo($emailUser);
            $msg->subject("Nuevo ticket generado");
            $admins=User::whereTipo("admin")->get();

            $i=0;
            foreach($admins as $admin) {
                if ($i > 0)
                    $msg->cc($admin->email, $admin->nombre);
                $i++;
            }
        });

        return parent::save($options);


    }


}


