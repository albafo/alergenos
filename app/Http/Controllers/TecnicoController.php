<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 16/06/15
 * Time: 23:08
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;



class TecnicoController extends Controller{

    public function __construct() {
        $this->middleware('tecnico');
    }

    public function getIndex(){
        return view('tecnico.index');
    }



}