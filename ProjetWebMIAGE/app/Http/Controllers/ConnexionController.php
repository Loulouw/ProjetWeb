<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * Class ConnexionController
 *
 * Controller contenant les méthdodes pour la Connexion
 *
 * @package App\Http\Controllers
 */
class ConnexionController extends Controller
{

    /**
     * Vérifie les informations et conencte l'utilisateur
     *
     * @param Request $request Parametre de la requete
     * @return Une vue en fonction de la connexion réussi ou non
     */
    public function connect(Request $request)
    {
        $messageRes = "<div class=\"alert alert-danger\">";
        $email="";
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if($request->user()->firstconnexion == 1){
                return Redirect::to('/firstConnexion');
            }else{
                return Redirect::to('/home');
            }
        }else{
            $messageRes .= "<li>Erreur dans la connexion, e-mail ou mot de passe incorrect</li>";
        }
        $messageRes .= "</div>";
        return Redirect::to('/')->with('messageErreurConnexion',$messageRes)->with('mailConnexion',$email);
    }
}