<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    @include('includes.header')
</head>
<body>
@include('includes.menu')
<div class="container-fluid text-center">
    <?php

    $seriesListFinal = "";
    $urlBase = "https://image.tmdb.org/t/p/w500";
    $count = 0;
    $ligne = "<div class='row'>";
    foreach ($series as $s) {
        $urlImage = $urlBase . $s->poster_path;
        if ($s->poster_path == null) {
            $urlImage = "img/unknow.png";
        }
        $count++;
        $ligne .= "<div class='col-xs-2'>
<a href='". url("series/$s->id") ."'><div class='thumbnail imgSeriesHome'>
<img idseries='" . $s->id . "' class='mg-rounded img-responsive' src='" . $urlImage . "' alt='" . $s->original_name . "'>
<div class='caption'>
        <h3>" . $s->original_name . "</h3>
        <p>" . substr($s->overview, 0, 100) . "...</p>
    </div>
</div></a>
</div>";
        if ($count == 6) {
            $count = 0;
            $seriesListFinal .= $ligne . "</div><br><br>";
            $ligne = "<div class='row'>";
        }
    }
    if ($count != 0) {
        $seriesListFinal .= $ligne . "</div>";
    }
    echo $seriesListFinal;

    echo $series->render();
    ?>

</div>
<script src="js/app.js"></script>
</body>
</html>