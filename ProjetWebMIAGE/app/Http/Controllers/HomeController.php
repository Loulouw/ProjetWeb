<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getSeries(){
    	$series= series::orderBy('popularity','desc')->take(30)->get();
        dd($series);
        return view('');
    }
}
