<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Class LogoutController
 *
 * Controller contenant les méthodes pour la deconnectop,
 *
 * @package App\Http\Controllers
 */
class LogoutController extends Controller
{
    /**
     * On vide la session et on retourne a l'accueil
     * @return mixed
     */
    public function logout(){
        Session::flush();
        return Redirect::to('/');
    }
}
