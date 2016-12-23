<?php

namespace App\Http\Controllers;

use App\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnexionController extends Controller
{
    public function connect(Request $request)
    {
        $messageRes = "<div class=\"alert alert-danger\">";
        $email="";
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if($request->user()->firstconnexion == 1){
                return view("firstconnection");
            }else{
                return view("home");
            }
        }else{
            $messageRes .= "<li>Erreur dans la connexion, email ou mot de passe incorrect</li>";
        }
        $messageRes .= "</div>";
        return view('accueil',['messageErreurConnexion' => $messageRes,'mailConnexion' => $email]);
    }
}