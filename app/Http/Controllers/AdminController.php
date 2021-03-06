<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Alergeno;
use App\Ticket;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 
	public function __construct() {
		$this->middleware('admin');
	}
	public function getIndex()
	{
		return view('admin.index');
	}
	
	public function getAlergenos() {
		$alergenos=Alergeno::all();
		return view('admin.alergenos', array('alergenos'=>$alergenos));
	}

	public function getIngredientes() {
		$alergenos=Alergeno::all();
		return view('admin.ingredientes', array('alergenos'=>$alergenos));
	}
	
	public function getUsuarios() {
		return view('admin.usuarios');
	}
	
	public function getTickets() {
		return view('admin.tickets');
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

}
