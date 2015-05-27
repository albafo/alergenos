<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Ticket;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Ingrediente;
use \DB;
use App\Http\Requests\CreateNewIngrediente;
class IngredienteController extends Controller {
    
    public function __construct() {
        $this->middleware('authLess');
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
	public function store(CreateNewIngrediente $request)
	{
		$this->middleware('admin');
		$ingrediente=new Ingrediente;
		$ingrediente->nombre=$request->get("nombre");
		$ingrediente->save();
		foreach($request->get("alergeno_id") as $alergeno_id) {
			if($alergeno_id!="none") {
				$ingrediente->alergenos()->attach($alergeno_id);
			}
		}

        if (is_array($request->get('idioma'))) {
            foreach($request->get('idioma') as $indexIdioma=>$traduccion) {

                $ingrediente->traduccion()->attach($indexIdioma, ['table_name'=>$ingrediente->getTable(), 'content' => $traduccion]);
            }
        }
	
		
	}
	
	public function find(Request $request) {
		$ingredientes=Ingrediente::findBySearch($request->get("find"))->orderBy('nombre', 'asc')->get();
        //$queries = DB::getQueryLog();
        $html="";

        foreach($ingredientes as $ingrediente) {
            $alergenos="Alérgenos(";
            $i=0;
            foreach($ingrediente->alergenos as $alergeno) {
                if($i>0){
                    $alergenos.=", ";
                }
                $alergenos.=$alergeno->nombre;
                $i++;
            }
            $alergenos.=")";
            $html.="<p data-index='".$ingrediente->id."'><strong>".$ingrediente->nombre."</strong> -> ".$alergenos."</p>";
        }
        $return['html']=$html;
        return $return;
	}
	
	
	public function findWithAlerg(Request $request) {
		$ingredientes=Ingrediente::findBySearch($request->get("find"))->orderBy('nombre', 'asc')->get();
        //$queries = DB::getQueryLog();
        $html="";
       
        foreach($ingredientes as $ingrediente) {
        	$alergenos="Alérgenos(";
        	$i=0;
        	foreach($ingrediente->alergenos as $alergeno) {
        		if($i>0){
        			$alergenos.=", ";
        		}
        		$alergenos.=$alergeno->nombre;
        		$i++;
        	}
        	$alergenos.=")";
            $html.="<p data-index='".$ingrediente->id."'><strong>".$ingrediente->nombre."</strong> -> ".$alergenos."</p>";
        }
        $return['html']=$html;
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
		$ingrediente=Ingrediente::find($id);
		$ingrediente->alergenos;
        $ingrediente->traduccion;
		return $ingrediente;
	
	}

    public function showByChar($char) {
    	
        //DB::connection()->enableQueryLog();
        $ingredientes=Ingrediente::findByChar($char)->orderBy('nombre', 'asc')->get();
        //$queries = DB::getQueryLog();
        $html="";
       
        foreach($ingredientes as $ingrediente) {
            $alergenos="Alérgenos(";
            $i=0;
            foreach($ingrediente->alergenos as $alergeno) {
                if($i>0){
                    $alergenos.=", ";
                }
                $alergenos.=$alergeno->nombre;
                $i++;
            }

            $alergenos.=")";
            $html.="<p data-index='".$ingrediente->id."'><strong>".$ingrediente->nombre."</strong> -> ".$alergenos."</p>";
        }
        $return['html']=$html;
        return $return;
    }
    
    public function showByCharAlerg($char) {
    	
        //DB::connection()->enableQueryLog();
        $ingredientes=Ingrediente::findByChar($char)->orderBy('nombre', 'asc')->get();
        //$queries = DB::getQueryLog();
        $html="";
       
        foreach($ingredientes as $ingrediente) {
        	$alergenos="Alérgenos(";
        	$i=0;
        	foreach($ingrediente->alergenos as $alergeno) {
        		if($i>0){
        			$alergenos.=", ";
        		}
        		$alergenos.=$alergeno->nombre;
        		$i++;
        	}
        	$alergenos.=")";
            $html.="<p data-index='".$ingrediente->id."'><strong>".$ingrediente->nombre."</strong> -> ".$alergenos."</p>";
        }
        $return['html']=$html;
        return $return;
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
	public function update(CreateNewIngrediente $request, $id)
	{
		$this->middleware('admin');
		$ingrediente=Ingrediente::find($id);
		
		foreach($ingrediente->alergenos as $alergeno) {
			if(!in_array($alergeno->id, $request->get('alergeno_id'))) {
				$ingrediente->alergenos()->detach($alergeno->id);
			}
		}
		
		foreach($request->get("alergeno_id") as $alergeno_id) {
			if($alergeno_id!="none" && !$ingrediente->alergenos->contains($alergeno_id)) {
				$ingrediente->alergenos()->attach($alergeno_id);
			}
		}
		
		if($ingrediente->nombre!=$request->get("nombre"))
			$ingrediente->nombre=$request->get("nombre");
		$ingrediente->save();

        if (is_array($request->get('idioma'))) {
            foreach($request->get('idioma') as $indexIdioma=>$traduccion) {

                if($traduccion) {

                    if(!$ingrediente->hasTraduccion($indexIdioma)) {
                        $ingrediente->traduccion()->attach($indexIdioma, ['table_name'=>$ingrediente->getTable(), 'content' => $traduccion]);
                    }

                    else $ingrediente->traduccion()->updateExistingPivot($indexIdioma, ['content'=>$traduccion]);
                }
                else {
                    $ingrediente->traduccion()->detach($indexIdioma);
                }

            }
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->middleware('admin');


        $ingrediente=Ingrediente::find($id);
        foreach(\App\Idioma::all() as $idioma) {
            if($ingrediente->hasTraduccion($idioma->id)) {
                $ingrediente->traduccion()->detach($idioma->id);
            }
        }

		Ingrediente::find($id)->delete();

	}
	
	public function peticion(Request $request) {
		$this->validate($request, [
        	'peticion' => 'required'
    	]);
    	
    	$ticket=new Ticket();
    	$ticket->peticion="Petición de ingredientes: ".$request->get('peticion');
    	\Auth::user()->tickets()->save($ticket);
	}

    public function getAlergeno($id_menu, $id_ingrediente) {

        $ids_alergenos=array();
        $alergenos = \DB::table("custom_alergenos")->select("alergeno_id")->where("menu_id", "=", $id_menu)->where("ingrediente_id", "=", $id_ingrediente)->get();



        foreach($alergenos as $alergeno) {

            $ids_alergenos[]=$alergeno->alergeno_id;
        }

        return $ids_alergenos;

    }

    public function editarVisibilidad($id_plato, $id_ingrediente) {

        $ingrediente=Ingrediente::find($id_ingrediente);
        if($ingrediente->plato()->find($id_plato)->pivot->visible_home)
            $ingrediente->plato()->updateExistingPivot($id_plato, ['visible_home'=>0]);

        else $ingrediente->plato()->updateExistingPivot($id_plato, ['visible_home'=>1]);

    }

}
