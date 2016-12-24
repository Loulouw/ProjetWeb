<?php

namespace App\Http\Controllers;

use App\series;
use Illuminate\Http\Request;

class FirstConnexionController extends Controller
{
    public function getSeries(){
        //SELECT * FROM `series` ORDER BY popularity DESC LIMIT 0,30"
        $series = series::orderBy('popularity','desc')->take(30)->get();
        dd($series);
        return view('firstconnexion');
    }
}
