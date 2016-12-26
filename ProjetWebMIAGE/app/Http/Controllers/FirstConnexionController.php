<?php

namespace App\Http\Controllers;

use App\Series;

class FirstConnexionController extends Controller
{
    public function getSeries(){
        $series = Series::orderBy('popularity','desc')->take(30)->get();
        return view('firstconnexion',["series   " => $series]);
    }
}
