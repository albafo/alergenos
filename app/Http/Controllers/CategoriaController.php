<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateNewCategoria;
use App\Http\Requests\ReordenarCategorias;
use App\Http\Requests\DeleteCategoria;

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
        
        
        
        
        
        $orden=Menu::find($id_menu)->categorias()->max('orden')+1;
        $categoria->orden=$orden;
        Menu::find($id_menu)->categorias()->save($categoria);
        
        
        if (is_array($request->get('idioma'))) {
    		foreach($request->get('idioma') as $indexIdioma=>$traduccion) {
            	if($traduccion != "")
            		$categoria->traduccion()->attach($indexIdioma, ['table_name'=>$categoria->getTable(), 'content' => $traduccion]);
            }
	    }
        
        $return['html']='<div class="panel panel-default caja-menu" id="categoria-'.$categoria->id.'">
                    <div class="editDel">
                        <div class="editar">
                            <a href="#"  title="Editar" class="glyphicon glyphicon-pencil editCat"></a>
                        </div>
                        <div class="borrar">
                            <a href="#" title="Borrar" class="glyphicon glyphicon-remove delCat"></a>
                        </div>
                    </div>
                    <div class="panel-body">'.$categoria->nombre.'</div>
                </div>';
        return $return;
        
	}
    
    public function reordenar(ReordenarCategorias $request, $id_menu){
        $orden=1;
        foreach($request->input('data') as $categoria) {
            $id=explode("-", $categoria)[1];
            $categoria=Categoria::find($id);
            $categoria->orden=$orden;
            $categoria->save();
            $orden++;
        }      
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
        

		$categoria=Menu::find($id_menu)->categorias()->find($id_cat);
        $categoria->nombre=$request->input('nombre');
        if (is_array($request->get('idioma'))) {
	        foreach($request->get('idioma') as $indexIdioma=>$traduccion) {
	        	
	        	if($traduccion) {
	        		
	        		if(!$categoria->hasTraduccion($indexIdioma)) {
	        			$categoria->traduccion()->attach($indexIdioma, ['table_name'=>$categoria->getTable(), 'content' => $traduccion]);
	        		}
	        		
	        		else $categoria->traduccion()->updateExistingPivot($indexIdioma, ['content'=>$traduccion]);
	        	}
	        	else {
	        		$categoria->traduccion()->detach($indexIdioma);
	        	}
	        
	        }
        }
        
        $categoria->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(DeleteCategoria $request, $id_menu, $id_cat)
	{

        $categoria=Categoria::find($id_cat);


        foreach(\App\Idioma::all() as $idioma) {
            if($categoria->hasTraduccion($idioma->id)) {
                $categoria->traduccion()->detach($idioma->id);
            }
        }

        $categoria->delete();
	}
	
	public function idiomas($id_cat) {
		if(\Auth::id()==Categoria::find($id_cat)->menu->user_id) {
			$idiomas=array();
			$i=0;
			
			foreach(\App\Idioma::all() as $idioma) {
				$idiomas[$i]["idIdioma"]=$idioma->id;
				$idiomas[$i]["nombreIdioma"]=$idioma->nombre;
				$categoria=Categoria::find($id_cat);
				$idiomas[$i]["traduccion"]="";
				if($traduccion=$categoria->traduccion()->find($idioma->id))
					$idiomas[$i]["traduccion"]=$traduccion->pivot->content;
				
				$i++;
			}
			
			
			
			return \Response::json($idiomas);
		}
		else abort(403);
	}

}
