<?php

namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 05/06/15
 * Time: 01:30
 */

class TestsController extends Controller
{

    public function getImpresion()
    {
        return view("menu.testPDF");
    }
}