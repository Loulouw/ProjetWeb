<!--Modal Inscription-->
<div class="modal fade modalAccueil" id="modalInscription" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><i class="glyphicon glyphicon-paperclip"></i> Inscription</h4>
            </div>
            <div class="modal-body">
                <?php
                if(session('mailInscription')) $mail = session('mailInscription'); else $mail = "";
                if(session('pseudoInscription')) $pseudo = session('pseudoInscription'); else $pseudo = "";
                if(session('messageErreurInscription')) echo session('messageErreurInscription');
                ?>
                <form role="form" action="{{action('InscriptionController@inscrip')}}" method="post"
                      name="inscriptionform">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name">Pseudo</label>
                            <input type="text" name="pseudo" placeholder="MonPseudo" required class="form-control" value="{{$pseudo}}"/>
                        </div>
                        <div class="form-group">
                            <label for="name">E-mail</label>
                            <input type="email" name="email" placeholder="mail@mail.com" required class="form-control" value="{{$mail}}"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Mot de passe</label>
                            <input type="password" name="password" placeholder="motDePasse" required
                                   class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Confirmation mot de passe</label>
                            <input type="password" name="password2" placeholder="motDePasse" required
                                   class="form-control"/>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="register" value="S'inscrire"
                                   class="btn btn-success btn-block btn-lg"/>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>