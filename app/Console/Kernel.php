<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
        'App\Console\Commands\AutoLangBlade'
        
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{

		$schedule->call(function() {
            $usersNotPaid = \DB::connection("mysql_ecede")->table("registroClientes")
                ->where('estadoPago', '<>', 1)
                ->where('envioNoPago' ,'=', 0)
                ->get();
            foreach($usersNotPaid as $user){
                $registrationTime = strtotime($user->fechaRegistro);
                if(time() > ($registrationTime + (60*60))) {

                    \DB::connection("mysql_ecede")->table("registroClientes")->where('id', $user->id)
                        ->update(['envioNoPago' => 1]);

                    \Mail::send('mail.userNoRegistered', ['user'=>$user], function($message) use ($user) {

                        $message->to($user->email, $user->contacto);
                        $message->bcc('alvaro1988@hotmail.com');
                        $message->from('soportealergias@adehon.org', 'ECEDE - Normativa alérgenos');
                        $message->subject("Te ayudamos a adaptarte a la normativa en alérgenos");
                    });
                }
            }
        })->cron('* * * * *');


	}

}
