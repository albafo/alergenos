<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\Ingrediente;



class CreateNewIngrediente extends Request {

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
		
			if($this->is('ingredientes/editar/*')) {
				return [
			        'nombre' => 'required|min:2|max:255'
				];
			}
			else {
				return [
			        'nombre' => 'required|min:2|max:255|unique:ingredientes,nombre,'.$this->id
				];
			}
		
	}
	
	

}
