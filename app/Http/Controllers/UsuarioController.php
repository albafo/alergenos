<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;

class UsuarioController extends Controller {
	
	public function __construct() {
		$this->middleware('admin');
	}
	
	public function viewUsuario($id) {
		
	}
	
	public function usuariosDT(Request $request) {
		//\DB::connection()->enableQueryLog();

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

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	


}
