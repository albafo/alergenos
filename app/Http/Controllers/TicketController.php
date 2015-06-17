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



        $tickets = Ticket::select(\DB::raw('tickets.*, usuarios.email, CONCAT(nombre, " ", apellidos) as usuario'))
            ->join('usuarios', 'tickets.user_id', '=', 'usuarios.id');


        $tickets_count=$tickets->count();
        $filtered_count=$tickets_count;

        if($order=$request->get('order')) {

            switch($order[0]["column"]) {

                case 0:
                    $tickets=$tickets->orderBy('usuario', $order[0]["dir"]);
                    break;
                case 1:
                    $tickets=$tickets->orderBy('email', $order[0]["dir"]);
                    break;
                case 2:
                    $tickets=$tickets->orderBy('peticion', $order[0]["dir"]);
                    break;
                case 3:
                    $tickets=$tickets->orderBy('tickets.created_at', $order[0]["dir"]);
                    break;
                case 4:
                    $tickets=$tickets->orderBy('leido', $order[0]["dir"]);
                    break;
            }
        }



		

		
		if($request->has('search') && $request->get('search')['value']!="") {

            $tickets=$tickets->orWhere('peticion', 'like', "%".$request->get('search')['value']."%");
            $tickets=$tickets->orWhere('email', 'like', "%".$request->get('search')['value']."%");
            $tickets=$tickets->orWhere(\DB::raw('CONCAT(nombre, " ", apellidos)'), 'like', "%".$request->get('search')['value']."%");

			//dd(\DB::getQueryLog());

		}





        if(!$order || $order[0]["column"]!=3) {
            $tickets=$tickets->orderBy('leido', 'ASC');
        }

        if(!$order || $order[0]["column"]!=4) {
            $tickets=$tickets->orderBy('tickets.created_at', 'ASC');
        }
        //\DB::enableQueryLog();
        $tickets=$tickets->get();


        //dd(\DB::getQueryLog());
		
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


    public function resolved($id) {
        $ticket=Ticket::find($id);
        $emailUser = $ticket->usuarios->email;
        $ticket->resuelto=1;
        $ticket->save();

        $data = [

            'fecha'=>date("d/M/Y H:i", time()),
            'nombre_usuario'=>$ticket->usuarios->nombre,
            'email_usuario'=>$emailUser,
            'descripcion'=>$ticket->peticion

        ];

        \Mail::send('mail.ticketSolved', ['data'=>$data], function($msg) use ($emailUser) {

            $firstAdmin = User::whereTipo("admin")->first();
            $msg->to($emailUser->email, $firstAdmin->nombre);
            $msg->from('info@alergias-hosteleria.com', '');
            $msg->subject("Ticket resuelto satisfactoriamente");


        });

        return redirect('admin/tickets')->withOk("Ticket resuelto. Email enviado al usuario.");
    }
}
