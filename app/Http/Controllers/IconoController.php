<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class IconoController extends Controller {

    public function show($id, $name) {
        if(\Auth::id() == $id) {
            $img = \Image::make(storage_path()."/app/iconos/".$id."/".$name);
            return $img->response();
        }
        else abort(403);
    }
    
}

