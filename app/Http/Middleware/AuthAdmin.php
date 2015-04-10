<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthAdmin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
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
	
	public function handle($request, Closure $next)
	{
	
		if(\Session::has('auth-admin')) {
			
			$auth_admin=\Session::get('auth-admin');
			$this->auth->loginUsingId($auth_admin->id);

		}
		
		if ($this->auth->guest() || $this->auth->user()->tipo!="admin")
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
		
		return $next($request);
	}

}
