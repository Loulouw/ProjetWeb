<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Support\Facades\Auth;

class FirstConnexionController extends Controller
{
    public function getSeries(){
        if(Auth::user()->firstconnexion == 1){
            $series = Series::orderBy('popularity','desc')->take(30)->get();
            return view('firstconnexion',["series" => $series]);
        }else{
            return view('home');
        }


    }
}
