<?php

namespace App\Http\Controllers;

use App\series;
use Illuminate\Http\Request;

class FirstConnexionController extends Controller
{
    public function getFilm(){
        //SELECT * FROM `series` ORDER BY popularity DESC LIMIT 0,30"
        $films = series::orderBy('popularity','desc')->take(30)->get();
        dd(films);
        return view('firstconnexion');
    }
}
