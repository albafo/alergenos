<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;
use Auth;
use App\Menu;
class saveMenu extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return Auth::id()==Menu::find($this->route('id'))->user_id;
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
            'caducidad'=>'regex:/^[0-3][0-9]\/[0-1][0-9]\/\d{4}$/',
            'descripcion'=>'max:255',
            'activo'=>'boolean',
            'precio'=>'numeric'
        ];
	}
	
	public function update_request() {
        
        
        $input = array_map('trim', $this->all());
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