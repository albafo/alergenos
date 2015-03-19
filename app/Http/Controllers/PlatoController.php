<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Categoria;

class PlatoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
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
	public function show($id_cat) {
        if(\Auth::id()==Categoria::find($id_cat)->menu->user_id)    {
            $platos=Categoria::find($id_cat)->platos()->orderBy('orden', 'asc')->get();
            $html="";
            
            foreach($platos as $plato) {
                $html.='<div class="panel panel-default caja-menu" id="plato-'.$plato->id.'">
                    <div class="editDel">
                        <div class="editar">
                            <a href="#"  title="Editar" class="glyphicon glyphicon-pencil editPlato"></a>
                        </div>
                        <div class="borrar">
                            <a href="#" title="Borrar" class="glyphicon glyphicon-remove delPlato"></a>
                        </div>
                    </div>
                    <div class="panel-body">'.$plato->nombre.' - '.$plato->precio.'€</div>
                </div>';
            }
            $return['html']=$html;
            return $return;
        }
        else abort(403);
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
	public function destroy($id)
	{
		//
	}

}
