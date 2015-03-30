<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewPlato;
use Illuminate\Http\Request;
use App\Categoria;
use App\Plato;

class PlatoController extends Controller {

    
    public function __construct() {
        
        $this->middleware('auth');
    }
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
	public function store(CreateNewPlato $request, $id_cat)
	{
		$plato=new Plato;
        $plato->fill($request->all());
        $orden=Categoria::find($id_cat)->platos()->max('orden')+1;
        $plato->orden=$orden;
        Categoria::find($id_cat)->platos()->save($plato);
        $html='<div class="panel panel-default caja-menu" id="plato-'.$plato->id.'">
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
        $return['html']=$html;
        return $return;
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

    public function showIngredientes($id_plato) {
        if(\Auth::id()==Plato::find($id_plato)->categoria->menu->user_id)    {
            $ingredientes=Plato::find($id_plato)->ingredientes();
            $html="";
            
            foreach($ingredientes as $ingrediente) {
                $html.='<div class="panel panel-default caja-menu" id="ingrediente-'.$ingrediente->id.'">
                    <div class="editDel">
                        <div class="editar">
                            
                        </div>
                        <div class="borrar">
                            <a href="#" title="Borrar" class="glyphicon glyphicon-remove delIngrediente"></a>
                        </div>
                    </div>
                    <div class="panel-body">'.$ingrediente->nombre.'</div>
                </div>';
            }
            $return['html']=$html;
            return $return;
        }
        else abort(403);
		//
	}
    
    /*Devuelve el modelo plato del id dado*/
    
    public function datos($id_plato) {
        if(\Auth::id()==Plato::find($id_plato)->categoria->menu->user_id)    {
            return Plato::find($id_plato);
        }
        else abort(403);
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
	public function update(Request $request, $id_plato)
	{
	    if(\Auth::id()==Plato::find($id_plato)->categoria->menu->user_id)    {
            $this->validate($request, [
                'nombre' => 'required|min:4|max:255',
                'precio' => 'numeric'
            ]);
            $plato=Plato::find($id_plato);
            $plato->fill($request->all());
            $plato->save();
            return $plato;
        }
        else abort(403);
	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id_plato)
	{
        
        if(\Auth::id()==Plato::find($id_plato)->categoria->menu->user_id)    {
            $this->validate($request, [
                'nombre' => 'required|min:4|max:255',
                'precio' => 'numeric'
            ]);
            Plato::find($id_plato)->delete();
        }
        else {
            abort(403);
        }

	}
    
    public function reordenar(Request $request, $id_cat) {
        if(\Auth::id()==Categoria::find($id_cat)->menu->user_id)    {
            $orden=1;
            foreach($request->input('data') as $plato) {
                $id=explode("-", $plato)[1];
                $plato=Plato::find($id);
                $plato->orden=$orden;
                $plato->save();
                $orden++;
            }      
        }
        else {
            abort(403);
        }
        
    }

}
