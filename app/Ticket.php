<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
}


