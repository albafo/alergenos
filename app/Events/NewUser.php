<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class NewUser extends Event {

	use SerializesModels;
	
	private $usuario;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->usuario=func_get_arg(0);
	}
	
	public function getUsuario() {
		return $this->usuario;
	}

}
