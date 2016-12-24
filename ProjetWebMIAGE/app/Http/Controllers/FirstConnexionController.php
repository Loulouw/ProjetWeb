<?php

namespace App\Http\Controllers;

use App\Series;

class FirstConnexionController extends Controller
{
    public function getSeries(){
        //SELECT * FROM `series` ORDER BY popularity DESC LIMIT 0,30"
        $series = Series::orderBy('popularity','desc')->take(30)->get();
        dd($series);
        return view('firstconnexion');
    }
}
