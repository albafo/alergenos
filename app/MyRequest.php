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
}
