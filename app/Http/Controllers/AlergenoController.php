<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNewAlergeno;
use App\Alergeno;
use Illuminate\Support\Facades\Storage;

class AlergenoController extends Controller {
	
	public function __construct() {
		$this->middleware('admin');
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
		return view('admin.alergenosForm');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateNewAlergeno $request)
	{
		$alergeno=new Alergeno;
		$alergeno->nombre=$request->get('nombre');
		$alergeno->descripcion=$request->get('descripcion');
		if ($request->file('image')->isValid())
		{
			$nombreImg=$request->file('image')->getClientOriginalName();
		    if(!Storage::disk('public')->exists("/img/".$nombreImg) && $request->file('image')->move(public_path()."/img", $nombreImg)) {
		    	$alergeno->img="img/".$nombreImg;
		    }
		    else{
		    	return view('admin.alergenosForm')->withErrors(['Fallo al cargar imagen en el servidor. Imagen ya existente o carpeta sin permisos']); 
		    }
		}
		else {
			return view('admin.alergenosForm')->withErrors(['Fallo al cargar imagen en el servidor']); 
		}
		$alergeno->save();

        if (is_array($request->get('idioma'))) {
            foreach($request->get('idioma') as $indexIdioma=>$traduccion) {

                $alergeno->traduccion()->attach($indexIdioma, ['table_name'=>$alergeno->getTable(), 'content' => $traduccion]);
            }
        }

		return redirect('admin/alergenos')->withOk('Alérgeno añadido con éxito');
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
		$alergeno=Alergeno::find($id);
		return view('admin.alergenosForm', array('alergeno'=>$alergeno));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateNewAlergeno $request, $id)
	{
		$alergeno=Alergeno::find($id);
		$alergeno->nombre=$request->get('nombre');
		$alergeno->descripcion=$request->get('descripcion');
		
		if($request->hasFile('image')){
			
			if ($request->file('image')->isValid())
			{
				$nombreImg=$request->file('image')->getClientOriginalName();
			    if(!Storage::disk('public')->exists("/img/".$nombreImg) && $request->file('image')->move(public_path()."/img", $nombreImg)) {
			    
			    	if(!Storage::disk('public')->delete("/".$alergeno->img)) {
			   			Storage::disk('public')->delete("/img/".$nombreImg);
			    		return redirect('admin/alergenos/editar/'.$id)->withErrors(['Fallo al eliminar imagen anterior']); 
			    	}
			    	$alergeno->img="img/".$nombreImg;
			    }
			    else{
			    	return redirect('admin/alergenos/editar/'.$id)->withErrors(['Fallo al cargar imagen en el servidor. Imagen ya existente o carpeta sin permisos']); 
			    }
			}
			else {
				return redirect('admin/alergenos/editar/'.$id)->withErrors(['Fallo al cargar imagen en el servidor. Imagen inválida']); 
			}
			
		}
		$alergeno->save();

        if (is_array($request->get('idioma'))) {
            foreach($request->get('idioma') as $indexIdioma=>$traduccion) {

                if($traduccion) {

                    if(!$alergeno->hasTraduccion($indexIdioma)) {
                        $alergeno->traduccion()->attach($indexIdioma, ['table_name'=>$alergeno->getTable(), 'content' => $traduccion]);
                    }

                    else $alergeno->traduccion()->updateExistingPivot($indexIdioma, ['content'=>$traduccion]);
                }
                else {
                    $alergeno->traduccion()->detach($indexIdioma);
                }

            }
        }

		return redirect('admin/alergenos/editar/'.$id)->withOk('Editado con éxito');	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$alergeno=Alergeno::find($id);
		Storage::disk('public')->delete("/".$alergeno->img);

        foreach(\App\Idioma::all() as $idioma) {
            if($alergeno->hasTraduccion($idioma->id)) {
                $alergeno->traduccion()->detach($idioma->id);
            }
        }

		$alergeno->delete();
		return redirect('admin/alergenos')->withOk('Alérgeno eliminado con éxito');
	}

}
