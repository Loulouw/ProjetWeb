<?php
$seriesListFinal = "";
if (isset($series)) {
    $urlBase = "https://image.tmdb.org/t/p/w500";
    $count = 0;
    $ligne = "<div class='row'>";
    foreach ($series as $s) {
        $count++;
        $ligne .= "<div class='col-xs-2'><img idseries='" . $s->id . "' class='imgSeriesFirstConnexion img-rounded img-responsive' src='" . $urlBase . $s->poster_path . "' alt='" . $s->original_name . "'></div>";
        if ($count == 6) {
            $count = 0;
            $seriesListFinal .= $ligne . "</div><br><br>";
            $ligne = "<div class='row'>";
        }
    }
    if ($count != 0) {
        $seriesListFinal .= $ligne . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    @include('includes.header')
</head>
<body>
<div class="flex-center position-ref full-height firstconnexionpage">
    <div class="entete_firstconnexion">
        <div class="flixnet_logo">
            FlixNet
        </div>
        <div class="instructionFirstConnexion text-center ">Veuillez sélectionner minimums 3 séries que vous avez déjà
            vues ou qui, potentiellement, pourrez-vous intéresser.<br><br></div>
    </div>
    <div class="container-fluid text-center">
        <?php
        echo $seriesListFinal;
        ?>
    </div>
    <div class="boutonDeConnexion">
        <form id="boutonFirstConnexion" role='form' action="{{action('HomeController@firstConnexionSeries')}}"
              method='post' name='firstSelectionForm'>
            {{ csrf_field() }}
            <div id="contenuBoutonFirstConnexion">

            </div>
        </form>
    </div>
</div>
<script src="js/app.js"></script>
<script src="js/selectFirstConnexion.js"></script>
</body>
</html>