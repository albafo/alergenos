<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Menu;
class ReordenarCategorias extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return \Auth::id()==Menu::find($this->route('id_menu'))->user_id;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}

}
