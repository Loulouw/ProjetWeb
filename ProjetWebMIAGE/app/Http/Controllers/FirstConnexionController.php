<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Support\Facades\Auth;

/**
 * Class FirstConnexionController
 *
 * Controller contenant les méthdodes pour la page de première connexion
 *
 * @package App\Http\Controllers
 */
class FirstConnexionController extends Controller
{
    /**
     * Obtient les 30 séries les plus populaires
     * @return return la vue firstconnexion avec les 30 séries
     */
    public function getSeries(){
        if(Auth::user()->firstconnexion == 1){
            $series = Series::orderBy('popularity','desc')->take(30)->get();
            return view('firstconnexion',["series" => $series]);
        }else{
            return view('home');
        }
    }
}