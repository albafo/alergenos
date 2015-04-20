<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

	//
	
	
	protected function getValidatorInstance()
	{
		$factory = $this->container->make('Illuminate\Validation\Factory');

		if (method_exists($this, 'validator'))
		{
			return $this->container->call([$this, 'validator'], compact('factory'));
		}

        if (method_exists($this, 'update_request'))
		{
		    $this->container->call([$this, 'update_request']);
		}

		return $factory->make(
			$this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
		);
	}

}
