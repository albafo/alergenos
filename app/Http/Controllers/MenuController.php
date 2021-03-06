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
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;

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
    
    public function getHerramientas($id) {
        if($menu=Auth::user()->menus()->find($id)) {
            return view('menu.herramientas',['menu'=>$menu]);
        }
        else abort(403);
    }

    
    public function getPreview($id, $id_plantilla, $traduccion) {
        if($menu=Auth::user()->menus()->find($id)) {
            $params = ['menu'=>$menu, 'traduccion'=>$traduccion];
            if(\Request::has("demo")) {
                $params["clientPreview"] = 1;
            }
            if(\Request::has('font-size')) {
                $params["fontSize"] = \Request::get('font-size');
            }
            return view('menu.preview-'.$id_plantilla,$params);
        }
        else abort(403);
    }
    
    
    
    public function getMenuPdf($id, $id_plantilla, $traduccion) {
        $snappy = App::make('snappy.pdf');

        //To file
        //$snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', '/tmp/bill-123.pdf');
        //$snappy->generate('http://www.github.com', '/tmp/github.pdf');
        //Or output:
        if($menu=Auth::user()->menus()->find($id)) {

            $params = ['menu'=>$menu, 'traduccion'=>$traduccion];
            if(\Request::has("demo")) {
                $params["clientPreview"] = 1;
            }
            if(\Request::has('font-size')) {
                $params["fontSize"] = \Request::get('font-size');
            }

            $view = view('menu.preview-'.$id_plantilla,$params);
            $view = str_replace("http://localhost:8080/web.Alergenos/public", public_path(), $view);

            //$compiledView = $view->render();
           


            return new Response(
                $snappy->getOutputFromHtml($view),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="'.$menu->nombre.'.pdf"'
                )
            );
        }else abort(403);
        
    }
    
    public function getExportListado() {
        $snappy = App::make('snappy.pdf');
        //To file
        //$snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', '/tmp/bill-123.pdf');
        //$snappy->generate('http://www.github.com', '/tmp/github.pdf');
        //Or output:
        
            
            
            
            $view = view('menu.listado-ingredientes');
            $view = str_replace("http://alvaro.dev:8080/web.Alergenos/public", public_path(), $view);

        //$compiledView = $view->render();
           


            return new Response(
                $snappy->getOutputFromHtml($view),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="listado-ingredientes.pdf"'
                )
            );
      
        
    }

    public function getExportCuadrante()
    {
        $snappy = App::make('snappy.pdf');
        $view = view('menu.cuadrante');

        /*return new Response(
            $snappy->getOutputFromHtml($view),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="cuadrante-platos.pdf"'
            )
        );*/

        $view = str_replace("http://alvaro.dev:8080/web.Alergenos/public", public_path(), $view);

        return \PDF::loadHTML($view)->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0)->download('cuadrante-platos.pdf');


    }
    
    
    
    public function getListadoIngredientes() {
        
            
            
            
            return view('menu.listado-ingredientes');
       
        
	    
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

    public function getCuadrantePlatos()
    {
        return view("menu.cuadrante");
    }

    public function getIndex() {
        $menus=Auth::user()->menus()->orderBy('estado', 'desc')->orderBy('created_at', 'desc')->paginate(4);
        return view("menus", ['menus'=>$menus]);
    }


}
