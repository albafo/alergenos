<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\EditUsuario;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

use App\User;

class UsuarioController extends Controller {
	
	public function __construct() {
		$this->middleware('auth', ['except'=>array('renew', 'paid', 'postPaid')]);
	}
	
	
	public function usuariosDT(Request $request) {
		//\DB::connection()->enableQueryLog();
		$this->middleware('admin');
		
		$users=User::where('tipo', '=', 'user');
		$users_count=$users->count();
		$filtered_count=$users_count;
		if($request->has('search') && $request->get('search')['value']!="") {
			$users=$users->where(function($query) use ($request) {
  				$query->orWhere('nombre', 'like', "%".$request->get('search')['value']."%")
  					->orWhere('apellidos', 'like', "%".$request->get('search')['value']."%")
                    ->orWhere('nombre_establ', 'like', "%".$request->get('search')['value']."%")
  					->orWhere('email', 'like', "%".$request->get('search')['value']."%");
			});
			$filtered_count=$users->count();
  		}
		if($request->has('order')) {
  			$colOrder=$request->get('order')[0]['column'];
  			$dirOrder=$request->get('order')[0]['dir'];
  			$colName=$request->get('columns')[$colOrder]['data'];
  			$users=$users->orderBy($colName, $dirOrder);
  		}
  		
		$users=$users->take($request->get("length"))->skip($request->get("start"))->get();
		
		$return['data']=$users->toArray();
		$return["draw"]=intval($request->get("draw"));
  		$return["recordsTotal"]=$users_count;
  		$return["recordsFiltered"]= $filtered_count;
  		//$queries = \DB::getQueryLog();
		//dd($queries);
		return $return;
	}

	
	
	public function edit() {
		return view('usuario.ficha');
	}
	
	public function update(EditUsuario $request) {
		$usuario=User::find(\Auth::user()->id);
		
		if(\Auth::user()->email!=$request->get("email")) {
			$usuario->email=$request->get("email");
		}
		if($request->has("password") && $request->get("password")!="") {
			if((\Auth::user()->tipo=="user" && \Session::has('auth-admin') && \Session::get('auth-admin')->tipo=="admin") || \Hash::check($request->get("password_old"), \Auth::user()->password)) {
		
				$usuario->password=\Hash::make($request->get("password"));
			}
			else {
				return redirect()->back()->withErrors("Contraseña antigua incorrecta");
			}
		}
		
		if(\Auth::user()->tipo=="user" && \Session::has("auth-admin") && \Session::get("auth-admin")->tipo=="admin") {
			if(!$request->has("status")) {
				$usuario->status=0;
			}
			else $usuario->status=$request->get("status");
		}
		
		$usuario->nombre=$request->get("nombre");
		$usuario->apellidos=$request->get("apellidos");
		$usuario->nombre_establ=$request->get("nombre_establ");
		$usuario->direccion=$request->get("direccion");
		$usuario->telefono=$request->get("telefono");
		
		
		if($request->hasFile("icono_estb") && $request->file('icono_estb')->isValid()) {
			if($usuario->icono_estb!="") {
				$this->eliminarIcono($usuario);
			}
			if(!$this->guardarIcono($usuario, $request)) {
				return redirect('usuario/datos')->withErrors(["Imagen ya existente en el servidor"]);
			}
		}
		else if($request->get("deletedImg")==1) {
			$this->eliminarIcono($usuario);
		}
		
		$usuario->save();
		\Auth::loginUsingId($usuario->id, \Auth::viaRemember());
		return redirect('usuario/datos')->withOk("Usuario editado con éxito");
	}
	
	public function eliminarIcono($usuario) {
		if(Storage::disk('iconos_estb')->exists($usuario->id."/".$usuario->icono_estb)) {
			Storage::disk('iconos_estb')->delete($usuario->id."/".$usuario->icono_estb);
		}
		$usuario->icono_estb="";
	}
	
	public function guardarIcono($usuario, $request) {
	
		$nombreImg=$request->file('icono_estb')->getClientOriginalName();
		if($usuario->icono_estb && Storage::disk('iconos_estb')->exists($usuario->id."/".$usuario->icono_estb)) {
			return false;
		}
		$request->file('icono_estb')->move(public_path()."/iconos-estb/".$usuario->id, $nombreImg);
		$usuario->icono_estb=$nombreImg;
		return true;
	}
	
	public function renew() {
		if(\Auth::guest()){
			return redirect("auth/login");
		}
		if(strtotime(\Auth::user()->expired_at) - time() > env('TIME_ACTIVATE_RENEW')) {
			return redirect("/home");
		}
		echo "Su suscripción ha finalizado. Pulse en \"Renovar\" si quiere seguir disfrutando del servicio.<br>
			<a href='http://www.ecede.es/formulario.php'>Renovar</a> <a href='".url("auth/logout")."'>Cerrar sesión</a>";
	}

    public function paid($id)
    {
        $user = User::find($id);

        if($user->password != "") {
            return redirect("auth/login");
        }
        else {
            return view('usuario.paid', ['id'=>$id, 'user'=>$user]);
        }
    }

    public function postPaid(Requests\PaidUser $request, $id)
    {
        $user = User::find($id);

        if($user->password != "") {
            return redirect("auth/login");
        }

        else {
            $user->password = bcrypt($request->get("password"));
            $user->expired_at = date('Y-m-d H:i:s', time()+env("DEFAULT_EXPIRATION_USER"));
            $user->save();
            return redirect("auth/login")->withOk("Usuario activado con éxito");
        }
    }

    public function getManual(Response $response)
    {
        \Auth::getUser()->manual_downloaded = 1;
        \Auth::getUser()->save();
        $file = public_path() . "/pdf-docs/manual.pdf";
        return response()->download($file, "Manual alergenos.pdf");
    }


    public function getCertificado()
    {
        $user = \Auth::user();
        if($user->hasCompletedMenu() && $user->manual_downloaded) {
            $snappy = \App::make('snappy.pdf');

            $view = view('usuario/certificado', ['user'=>$user]);

            $view = str_replace("http://alvaro.dev:8080/web.Alergenos/public", public_path(), $view);

            return \PDF::loadHTML($view)->setPaper('a4')->setOption('margin-bottom', 0)->setOption('margin-top', 0)->setOption('margin-left', '5mm')->setOption('margin-right', '5mm')->download('Certificado 1169/2011.pdf');
        }
        else return \Redirect('home');

    }

    public function testCertificado() {
        $user = \Auth::user();
        return view('usuario/certificado',  ['user'=>$user]);
    }

    public function remove()
    {
        if(\Auth::user()->tipo=="user" && \Session::has('auth-admin') && \Session::get('auth-admin')->tipo=="admin") {
            \Auth::user()->delete();
            return \Redirect('admin/usuarios');
        }
    }



}
