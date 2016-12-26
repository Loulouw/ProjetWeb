<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function firstConnexionSeries(Request $request){
        foreach ($request->series as $s){

        }
        dd($request);
    }

    public function getSeries(){
    	$series= Series::orderBy('popularity','desc')->take(30)->get();
        return view('');
    }
}
