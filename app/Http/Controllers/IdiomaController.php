<?php namespace App\Http\Controllers;

use App\Http\Requests\IdiomaRequest;
use App\Idioma;

class IdiomaController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function getIndex() {
        return view('idiomas.idiomas');
    }
    
    public function postNuevo(IdiomaRequest $request) {
        $idioma=new Idioma;
        $idioma->nombre=$request->get('nombre');
        \Auth::user()->idiomas()->save($idioma);
        return redirect('idiomas')->withOk('Idioma creado con éxito');
    }
    
    public function getEditar(IdiomaRequest $request) {
       
        $idioma=Idioma::find($request->route('id'));
        $idioma->nombre=$request->get('nombre');
        $idioma->save();
        return redirect('idiomas')->withOk('Idioma editado con éxito');;
        
    }
    
    public function getBorrar(IdiomaRequest $request) {
        Idioma::find($request->route('id'))->delete();
        return redirect('idiomas')->withOk('Idioma eliminado con éxito');;
    }
    
    
}