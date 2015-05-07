<?php namespace App\Http\Requests;

use App\Http\Requests\Request;



class EditUsuario extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
	    return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		
		$returnArray=[
	    	'nombre' => 'required|min:2|max:255',
	        'apellidos'=>'required|min:4|max:255',
	        'icono_estb'=>'image|max:500'
		];

		
		if(\Auth::user()->email!=$this->request->get("email")) {
			$returnArray['email']='required|confirmed|email|unique:usuarios';
		}

		if($this->request->has("password_old") && $this->request->get("password_old")!="") {
			
			
			if((\Auth::user()->tipo=="user" && !\Session::has('auth-admin')) || \Auth::user()->tipo=="admin")
				$returnArray['password_old']='required';
				
			$returnArray['password']='required|confirmed|min:6';
			
			
				
		}
		


		if(\Auth::user()->tipo=="user" && \Session::has("auth-admin") && \Session::get("auth-admin")->tipo=="admin") {
			$returnArray['status']='boolean';
		
		}
		
		return $returnArray;
	}
	

}
