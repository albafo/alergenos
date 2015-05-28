<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Events\NewUser;
use App\User;


/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{

		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => array('getLogout', 'getActivation', 'postActivar')]);

	}

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout() {
		$this->auth->logout();
		\Session::flush();
		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
		
	}

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			
			return redirect($this->redirectPath());
		}

		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
	}
	
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->registrar->create($request->all()));

		event(new NewUser($this->auth->user()));

        /* Añadimos código aleatorio al usuario */


        /**
         * @var $user \App\User
         * */

        $user = $this->auth->user();

        $code = $user->setRandomActivation();

        $this->sendNewUserMail($code);

		return redirect($this->redirectPath());
	}
	
	public function getRenew() {
		echo "Próximamente";
	}

    public function sendNewUserMail($codigo) {

        $emailUser = $this->auth->user()->email;

        $data = [

            'fecha'=>date("d/M/Y H:i", time()),
            'nombre_usuario'=>$this->auth->user()->nombre,
            'email_usuario'=>$emailUser,
            'codigo'=>$codigo

        ];

        \Mail::send('mail.newUser', ['data'=>$data], function($msg) use ($emailUser) {


            $firstAdmin=User::whereTipo("admin")->first();
            $msg->to($firstAdmin->email, $firstAdmin->nombre);
            $msg->from('web@alergias-hosteleria.com', '');
            $msg->replyTo($emailUser);
            $msg->subject("Nuevo ticket generado");
            $admins=User::whereTipo("admin")->get();

            $i=0;
            foreach($admins as $admin) {
                if ($i > 0)
                    $msg->cc($admin->email, $admin->nombre);
                $i++;
            }
        });
    }
	
	public function redirectPath(){
	
		if($this->auth->user()->tipo=="admin"){
		
			return '/admin';
		}
		else {
			if (property_exists($this, 'redirectPath'))
			{
				return $this->redirectPath;
			}
	
			
			return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
		}
	}


    public function getActivation() {


        if($this->auth->user()->confirmed) {
            return redirect("/home");
        }

        return view("usuario.activacion");
    }

    public function postActivar(Request $request) {
        if($request->get("codigoActivacion") == $this->auth->user()->activation_code) {
            $this->auth->user()->confirmed=1;
            $this->auth->user()->save();
            return redirect("/home")->withOk("Usuario activado con éxito");
        }

        return redirect("/auth/activation")->withErrors(array("Código incorrecto."));
    }

    public function getTest() {
        echo  gethostbyname ('http://www.google.com');

    }

}
