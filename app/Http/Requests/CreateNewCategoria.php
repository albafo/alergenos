<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Menu;
use App\Categoria;


class CreateNewCategoria extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return \Auth::id()==Menu::find($this->route('id'))->user_id;
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
