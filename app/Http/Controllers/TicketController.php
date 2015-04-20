<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	public function __construct() {
		$this->middleware('admin');
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
	
	public function getTicket($id) {
		$ticket=Ticket::find($id);
		$ticket->leido=1;
		$ticket->save();
		return view('ticket.index', ['ticket'=>$ticket]);
	}

	public function ticketsTable(Request $request) {
		
		
		
		$tickets = Ticket::with(['usuarios'=> function($query) {
			$query->select('*', \DB::raw('CONCAT(nombre, " ", apellidos) as usuario'));		
		}])->orderBy('leido', 'ASC')->orderBy('created_at', 'ASC')->get();
		
		$tickets_count=$tickets->count();
		$filtered_count=$tickets_count;
		
		if($request->has('search') && $request->get('search')['value']!="") {
			//\DB::connection()->enableQueryLog();
			$tickets = Ticket::with(['usuarios'=> function($query) {
					$query->select('*', \DB::raw('CONCAT(nombre, " ", apellidos) as usuario'));
			}])->whereHas('usuarios', function($query) use ($request)
			{
			    $query->where(function($query) use ($request) {
			    	$query->where(\DB::raw('CONCAT(nombre, " ", apellidos)'), 'like', "%".$request->get('search')['value']."%")
			    	->orWhere('email', 'like', "%".$request->get('search')['value']."%");
			    });
			   
			})
			->orWhere('peticion', 'like', "%".$request->get('search')['value']."%");
			
			$filtered_count=$tickets->count();
			$tickets=$tickets->orderBy('leido', 'ASC')->orderBy('created_at', 'ASC')->get();
			//dd(\DB::getQueryLog());

		}
		
		//$tickets_count=$tickets->count();
		//$filtered_count=$tickets_count;
		
		

		$return['data']=$tickets->toArray();
		$return["draw"]=intval($request->get("draw"));
  		$return["recordsTotal"]=$tickets_count;
  		$return["recordsFiltered"]= $filtered_count;

		return $return;
		
		/*
		if($request->has('search') && $request->get('search')['value']!="") {
			$users=$users->where(function($query) use ($request) {
  				$query->orWhere('CONCAT(nombre, " ", apellidos)', 'like', "%".$request->get('search')['value']."%")
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
		
		*/
	}
	
	public function removeReaded($id) {
		$ticket=Ticket::find($id);
		$ticket->leido=0;
		$ticket->save();
		return redirect('admin/tickets');
	}
	
	public function remove($id) {
		$ticket=Ticket::find($id)->delete();
		return redirect('admin/tickets')->withOk("Eliminado con éxito");
	}
	
}
