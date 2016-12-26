<?php

namespace App\Http\Controllers;

use App\Series;
use App\UsersSeries;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function firstConnexionSeries(Request $request){
        $idusers = $request->user()->id;
        foreach ($request->series as $s){
            $us = new UsersSeries();
            $us->id_users = $idusers;
            $us->id_series = $s;
            $us->save();
        }
        $request->user()->firstconnexion = 0;
        $request->user()->save();

        return view("home");
    }

    public function getSeries(){
    	$series= Series::orderBy('popularity','desc')->take(30)->get();
        return view('home');
    }
}
