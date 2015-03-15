<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
        //dd($data);
		return Validator::make($data, [
			'nombre' => 'required|max:255',
			'email' => 'required|email|max:255|unique:usuarios',
			'password' => 'required|confirmed|min:6',
            'g-recaptcha-response' => 'required|captcha'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
        
        $num=rand(1000, 9999);
        $hash=bcrypt("".$num);
        
		return User::create([
			'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
			'email' => $data['email'],
            'email_confirmation'=>$hash,
			'password' => bcrypt($data['password'])
		]);
	}

}
