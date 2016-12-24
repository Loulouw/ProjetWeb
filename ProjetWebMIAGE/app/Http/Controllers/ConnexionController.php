<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class ConnexionController extends Controller
{
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