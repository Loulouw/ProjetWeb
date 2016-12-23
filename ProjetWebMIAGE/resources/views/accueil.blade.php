<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    @include('includes.header')
</head>
<body>

<div class="flex-center position-ref full-height">
    <div class="accueil_non_connecte">
        <!--Caroussel placé à l'index 0-->
        <div id="caroussel_accueil_non_connecte" class="carousel afade">
            <!-- Caroussel d'écran d'accueil -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="fill" style='background-image:url("img/caroussel_accueil/back1-min.jpg");'></div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('img/caroussel_accueil/back2-min.jpg');"></div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('img/caroussel_accueil/back3-min.jpg');"></div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('img/caroussel_accueil/back4-min.jpg');"></div>
                </div>
                <div class="item">
                    <div class="fill" style="background-image:url('img/caroussel_accueil/back5-min.jpg');"></div>
                </div>
            </div>
        </div>
        <!--Texte placé à l'index 1-->
        <div class="text_accueil_non_connecte">
            <div class="logo_accueil_non_connecte">
                FlixNet
            </div>
            <button class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#modalConnexion">
                Connexion
            </button>
            <button class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#modalInscription">
                Inscription
            </button>
        </div>
    </div>
</div>

@include('includes.connexion')
@include('includes.inscription')

<script src="js/app.js"></script>
<script src="js/script.js"></script>
<?php
if(isset($messageErreurInscription)) echo '<script type="text/javascript">$("#modalInscription").modal("show");</script>';
if(isset($messageErreurConnexion)) echo '<script type="text/javascript">$("#modalConnexion").modal("show");</script>';

?>
</body>
</html>