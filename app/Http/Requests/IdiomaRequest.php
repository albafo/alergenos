<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Idioma;

class IdiomaRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
	    if($this->route('id'))
		    return \Auth::id()==Idioma::find($this->route('id'))->user_id;
		else return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        if (Request::is('idioma/borrar/*')) {
            return [];
        }
        
		return [
            'nombre' => 'required|min:4|max:255',
        ];
	}
    
   


}
