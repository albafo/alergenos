<?php namespace App\Http\Requests;

use App\Http\Requests\Request;



class CreateNewAlergeno extends Request {

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
		if($this->is('admin/alergenos/editar/*')) {
			return [
		        'nombre' => 'required|min:4|max:255',
		        'descripcion'=>'min:4|max:255',
		        'image'=>'image|max:100'
			];
		}
		else {
			return [
		        'nombre' => 'required|min:4|max:255',
		        'descripcion'=>'min:4|max:255',
		        'image'=>'required|image|max:100'
			];
		}
	}

}
