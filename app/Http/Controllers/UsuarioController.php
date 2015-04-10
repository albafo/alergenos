<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\EditUsuario;
use Illuminate\Support\Facades\Storage;

use App\User;

class UsuarioController extends Controller {
	
	public function __construct() {
		$this->middleware('auth');
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
		
		if($request->hasFile("icono_estb") && $request->file('icono_estb')->isValid()) {
			if($usuario->icono_estb!="") {
				$this->eliminarIcono($usuario);
			}
			$this->guardarIcono($usuario, $request);
		}
		else if($request->get("deletedImg")==1) {
			$this->eliminarIcono($usuario);
		}
		
		$usuario->save();
		\Auth::loginUsingId($usuario->id, \Auth::viaRemember());
		return redirect('usuario/datos')->withOk("Usuario editado con éxito");
	}
	
	public function eliminarIcono($usuario) {
		if(Storage::exists($usuario->icono_estb)) {
			Storage::delete($usuario->icono_estb);
			$usuario->icono_estb="";
		}
	}
	
	public function guardarIcono($usuario, $request) {
	
		$nombreImg=$request->file('icono_estb')->getClientOriginalName();
		if(Storage::exists("app/iconos/".$usuario->id."/".$nombreImg)) {
			return redirect('usuario/datos')->withErrors(["Imagen ya existente en el servidor"]);
		}
		$request->file('icono_estb')->move(storage_path()."/app/iconos/".$usuario->id, $nombreImg);
		$usuario->icono_estb="iconos/".$usuario->id."/".$nombreImg;
	}


}
