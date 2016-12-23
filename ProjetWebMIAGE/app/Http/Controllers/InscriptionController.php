<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\users;
use Illuminate\View\View;

class InscriptionController extends Controller
{
    public function inscrip(Request $request){
        $valide=true;
        $email="";
        $pseudo="";

        $messageRes = "<div class=\"alert alert-danger\">";
        if($this->checkEmailFormat($request->email)){
            if(!$this->checkEmailDispo($request->email)){
                $messageRes .= "<li>Email déjà existant</li>";
                $valide=false;
            }else{
                $email = $request->email;
            }
        }else{
            $messageRes .= "<li>Email au mauvais format</li>";
            $valide=false;
        }

        if($this->checkMotDePasseLongueur($request->password)){
            if(!$this->checkMotDePasseEgaux($request->password,$request->password2)){
                $messageRes .= "<li>Les mots de passes ne sont pas égaux</li>";
                $valide=false;
            }
        }else{
            $messageRes .= "<li>La longueur du mot passe doit être minimum de 5 caractères</li>";
            $valide=false;
        }

        if(!$this->checkPseudo($request->pseudo)){
            $messageRes .= "<li>La longueur du pseudo doit être de minimum de 3 caractères</li>";
            $valide=false;
        }else{
            $pseudo=$request->pseudo;
        }
        $messageRes .= "</div>";

        if($valide){
            $user = new User();
            $user->name = $request->pseudo;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->save();
            $messageRes = "<div class=\"alert alert-success\"><strong>Inscription réussie! </strong>Veuillez-vous connecter</div>";
            return view('accueil',['messageErreurConnexion' => $messageRes,'mailConnexion' => $request->email]);
        }else{
            return view('accueil',['messageErreurInscription' => $messageRes,'mailInscription' => $email,'pseudoInscription' => $pseudo]);
        }
    }

    private function checkEmailFormat($mail){
        $res = false;
        if(filter_var($mail,FILTER_VALIDATE_EMAIL)) $res = true;
        return $res;
    }

    private function checkEmailDispo($mail){
        $res = false;
        if(users::where('email','=',$mail)->first() == null) $res = true;
        return $res;
    }

    private function checkMotDePasseLongueur($motDePasse){
        $res = false;
        if(strlen($motDePasse) > 5) $res = true;
        return $res;
    }

    private function checkMotDePasseEgaux($motDePasse1,$motDePasse2){
        $res = false;
        if(strcmp($motDePasse1,$motDePasse2) == 0) $res = true;
        return $res;
    }

    private function checkPseudo($pseudo){
        $res = false;
        if(strlen($pseudo) >= 3) $res = true;
        return $res;
    }
}
