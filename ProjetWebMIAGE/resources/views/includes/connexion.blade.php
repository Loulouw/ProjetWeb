<!--Modal Connexion-->
<div class="modal fade modalAccueil" id="modalConnexion" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><i class="glyphicon glyphicon-lock"></i> Connexion</h4>
            </div>
            <div class="modal-body">
                <?php
                if(session('messageErreurConnexion')) echo session('messageErreurConnexion');
                ?>
                <form role="form" action="{{action('ConnexionController@connect')}}" method="post" name="loginform">
                    <fieldset >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" placeholder="mail@mail.com" required class="form-control" value="{{session('mail')}}"/>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" placeholder="motDePasse" required class="form-control" />
                        </div>

                        <div class="form-group">
                            <input type="submit" name="login" value="Se connecter" class="btn btn-success btn-block btn-lg" />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>