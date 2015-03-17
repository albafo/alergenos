<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateNewCategoria;
use App\Http\Requests\UpdateCategoria;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Database\Connection;
class CategoriaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
    public function __construct() {
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
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateNewCategoria $request, $id_menu)
	{   
  
        $categoria=new Categoria();
        $categoria->nombre=$request->input('nombre');
        Menu::find($id_menu)->categorias()->save($categoria);
        
        $return['html']='<div class="panel panel-default caja-menu" id="categoria-'.$categoria->id.'">
                    <div class="editDel">
                        <div class="editar">
                            <a href="#"  title="Editar" class="glyphicon glyphicon-pencil editCat"></a>
                        </div>
                        <div class="borrar">
                            <a href="#" title="Borrar" class="glyphicon glyphicon-remove"></a>
                        </div>
                    </div>
                    <div class="panel-body">'.$categoria->nombre.'</div>
                </div>';
        return $return;
        
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
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateCategoria $request, $id_menu, $id_cat)
	{
        \DB::connection()->enableQueryLog();

		$categoria=Menu::find($id_menu)->categorias()->find($id_cat);
        
        $categoria->nombre=$request->input('nombre');
        $categoria->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
