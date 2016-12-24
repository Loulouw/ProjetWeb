<?php

namespace App\Http\Controllers;

use App\Series;

class HomeController extends Controller
{
    public function getSeries(){
    	$series= Series::orderBy('popularity','desc')->take(30)->get();
        dd($series);
        return view('');
    }
}
