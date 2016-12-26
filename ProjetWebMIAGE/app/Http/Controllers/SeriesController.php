<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SeriesController extends Controller
{
    public function seriesInformation(Request $request){
        return Redirect::to("/series/$request->id");
    }
}
