<?php

namespace App\Http\Controllers;

use App\Genres;
use Illuminate\Http\Request;

class RechercheController extends Controller
{

    /**
     * On récupère tous les genres existant
     * @return vue recherche avec les genres
     */
    public function getAllGenre()
    {
        $genres = Genres::all();
        return view('rechercher')->with('genres', $genres);
    }
}
