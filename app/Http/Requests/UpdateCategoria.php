<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Menu;
use App\Categoria;


class UpdateCategoria extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return (\Auth::id()==Menu::find($this->route('id_menu'))->user_id  
       && Menu::find($this->route('id_menu'))->categorias()->find($this->route('id_cat'))->exists());
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
	        'nombre' => 'required|min:4|max:255'
		];
	}

}