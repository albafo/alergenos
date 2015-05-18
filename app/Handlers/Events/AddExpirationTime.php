<?php namespace App\Handlers\Events;

use App\Events\NewUser;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class AddExpirationTime {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  NewUser  $event
	 * @return void
	 */
	public function handle(NewUser $event)
	{
		$event->getUsuario()->expired_at=date('Y-m-d H:i:s', time()+env("DEFAULT_EXPIRATION_USER"));

		$event->getUsuario()->save();
	}

}
