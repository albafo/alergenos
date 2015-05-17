<?php
namespace App;
use Illuminate\Support\Facades\Request;


class MyRequest extends Request{
    
    public static function mySegments(){
        $i=0;
        $segmentos="";
        foreach(Request::segments() as $segmento) {
            
            if($i!=0){
                $segmentos.="-";
            }
                
            $segmentos.=$segmento;
            $i++;
        }
        return $segmentos;
    }

    public static function customJavascript(){
        $path=Request::path();

        $path_parts = explode("/", $path);

        $parts = "";

        for($i=0; $i<sizeof($path_parts)-1; $i++) {
            $parts=$path_parts[$i]."/";
        }


        $fileJSabsolute = public_path()."/js/".$parts.$path_parts[sizeof($path_parts)-1].".js";

        $fileJSrelative = asset("/js/".$parts.$path_parts[sizeof($path_parts)-1].".js");




        $return = "";

        if(\File::exists($fileJSabsolute)) {
            $return =  '<script src="'.($fileJSrelative).'"></script>';

        }

        return $return;

    }
}
