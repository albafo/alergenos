<?php namespace App\Http\Requests;
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 18/06/15
 * Time: 19:35
 */

use App\Http\Requests\Request;


    class PaidUser extends Request{

    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return array(
            "password" =>'required|confirmed|min:6'
        );
    }
}