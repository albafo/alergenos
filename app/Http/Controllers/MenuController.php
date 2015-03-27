<?php namespace App\Http\Controllers;

use App\Http\Requests\createNewMenu;
use App\Http\Requests\saveMenu;
use App\Http\Requests\EliminarMenu;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Menu;
use Auth;
use App;
use App\Librerias\DateFormat\DateSql;

class MenuController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
    public function __construct()
	{
		$this->middleware('auth');
	}
    
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postCreate(createNewMenu $request)
	{
        $name=$request->input('nombreMenu');
        $menu=new Menu();
        $menu->nombre=$name;
        Auth::user()->menus()->save($menu);
        $return['id']=$menu->id;
        return $return;
        
	}
    
    public function getPlatosMenu(Request $request, $id) {
        if($menu=Auth::user()->menus()->find($id)) {
            return view('menu.platosMenu',['menu'=>$menu]);    
        }
        else {
            abort(403);

        }
    }
    
    public function getDatosMenu(Request $request, $id) {
        if($menu=Auth::user()->menus()->find($id)) {
            return view('menu.datosMenu',['menu'=>$menu]);    
        }
        else {
            abort(403);

        }
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(saveMenu $request, $id)
	{
        $input = array_map('trim', $request->all());
        if($input['caducidad']!="") {
	        $input['caducidad']=DateSql::changeToSql($input['caducidad']);
        }
        else {
            $input['caducidad']=null;
        }
        if(!isset($input['estado'])) {
            $input['estado']=0;
        }
        $request->replace($input);
        Menu::find($id)->update($request->all());
        return redirect('menu/datos-menu/'.$id)->with('ok', 'Actualizado con éxito');;
 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(EliminarMenu $request, $id)
	{
        
        Menu::find($id)->delete();
        return redirect('home')->with('ok', 'Menú eliminado con éxito');;
	}

}
