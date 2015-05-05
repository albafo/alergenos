<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Categoria;

class CreateNewPlato extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return \Auth::id()==Categoria::find($this->route('id_cat'))->menu->user_id;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        
		return [
            'nombre' => 'required|min:4|max:255',
            'precio' => 'numeric'
        ];
	}
    
    public function update_request() {
        
        
        $input = array_map(function($a) {
            return $a;
        }, $this->all());
        if($input['precio']!="") {
            $input['precio'] = str_replace(',', '.', $input['precio']);
            $input['precio'] = str_replace('€', '', $input['precio']);
            $input['precio'] = str_replace('$', '', $input['precio']);


        }
        else {
            unset($input['precio']);
        }
        $this->replace($input);
    }

}
