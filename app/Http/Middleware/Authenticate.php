<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}
		
		if($this->auth->user()->tipo!="admin" && strtotime($this->auth->user()->expired_at)<=time()) {
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect('user/renew');
			}
		}
		
		if($this->auth->user()->tipo=="admin") {
		
			if($request->is("admin/usuarios*") || $request->is("usuario/datos*")) {
				
				return $next($request);
			}
			if($request->is("admin/usuario/*")) {
				\Session::put("auth-admin", $this->auth->user());
				$this->auth->loginUsingId($request->id);
				return $next($request);
			}
			return redirect()->guest('admin');
		}
		
		
        
        //Activar cuando esté el envío por mail
        /* 
         * Realiza la verificación de si el usuario ha confirmado su cuenta.    
         * 
          
         
        if($this->auth->user()->confirmed==0){
            $errors=['No has confirmado tu cuenta. Por favor, revisa tu email.'];
            $this->auth->logout();
            return redirect('auth/login')->withErrors($errors);
        }*/
        
        

		return $next($request);
	}

}
