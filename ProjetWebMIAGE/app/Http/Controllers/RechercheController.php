<?php

namespace App\Http\Controllers;

use App\Genres;
use Illuminate\Http\Request;

class RechercheController extends Controller
{

    public function getAllGenre()
    {
        $genres = Genres::all();
        return view('rechercher')->with('genres', $genres);
    }
}
