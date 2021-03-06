<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/**
 * Controller contenant les méthodes pour la page d'accueil avec l'inscription
 * Class InscriptionController
 * @package App\Http\Controllers
 */
class InscriptionController extends Controller
{
    /**
     * Va tester les différents paramètres de la requete
     * @param Request $request
     * @return mixed
     */
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
            $messageRes .= "<li>La longueur du mot passe doit être minimum de 6 caractères</li>";
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

            return Redirect::to('/')->with('messageInscriptionReussi',$messageRes)->with('mailConnexion',$request->email);
        }else{
            return Redirect::to('/')->with('messageErreurInscription',$messageRes)->with('mailInscription',$email)->with('pseudoInscription',$pseudo);
        }
    }

    /**
     * Regarde le format de l'mail
     * @param $mail
     * @return bool
     */
    private function checkEmailFormat($mail){
        $res = false;
        if(filter_var($mail,FILTER_VALIDATE_EMAIL)) $res = true;
        return $res;
    }

    /**
     * Regarde la disponibilité de l'email
     * @param $mail
     * @return bool
     */
    private function checkEmailDispo($mail){
        $res = false;
        if(User::where('email','=',$mail)->first() == null) $res = true;
        return $res;
    }

    /**
     * Regarde la longeur du mot de passe
     * @param $motDePasse
     * @return bool
     */
    private function checkMotDePasseLongueur($motDePasse){
        $res = false;
        if(strlen($motDePasse) > 5) $res = true;
        return $res;
    }

    /**
     * Regarde si les deux mot de passes sont égaux
     * @param $motDePasse1
     * @param $motDePasse2
     * @return bool
     */
    private function checkMotDePasseEgaux($motDePasse1,$motDePasse2){
        $res = false;
        if(strcmp($motDePasse1,$motDePasse2) == 0) $res = true;
        return $res;
    }

    /**
     * Vérifie le pseudo
     * @param $pseudo
     * @return bool
     */
    private function checkPseudo($pseudo){
        $res = false;
        if(strlen($pseudo) >= 3) $res = true;
        return $res;
    }
}
