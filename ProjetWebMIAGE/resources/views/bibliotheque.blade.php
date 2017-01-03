<?php
$count = 0;
$firstSeries = true;
$contentTabLike = "";
foreach ($seriesLike as $s) {
    $count++;
    if ($count == 1) {
        if ($firstSeries) {
            $contentTabLike .= "<div class='item active'>";
            $firstSeries = false;
        } else {
            $contentTabLike .= "<div class='item'>";
        }
        $contentTabLike .= "<div class='row'>";
    }

    $urlImageSeriesLike = url("/") . "/img/unknow_episode.png";
    if ($s->backdrop_path != null) $urlImageSeriesLike = "https://image.tmdb.org/t/p/w500" . $s->backdrop_path;

    $contentTabLike .= " <div class='col-sm-3'>
                                        <a href='" . url("series/$s->id_series") . "' class='thumbnail'>
                                            <img src='" . $urlImageSeriesLike . "' alt='" . $s->original_name . "' class='img-responsive'>
                                            <div class='textCarousselProposition'>" . $s->original_name . "</div>
                                        </a>
                                    </div>";


    if ($count == 4) {
        $contentTabLike .= "</div></div>";
        $count = 0;
    }
}
if($count!=0){
    $contentTabLike .= "</div></div>";
}
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    @include('includes.header')
</head>
<body>
@include('includes.menu')
<div class="container-fluid text-center">
    <div class="serieFavorite">
        <h3>Mes séries favorites</h3>
        <hr>
        <div class="col-md-12">
            <div class="well">
                <div id="carousselSerieLike" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner center-block">
                        <!--/item-->
                        {!!$contentTabLike!!}
                    </div>
                    <!--/carousel-inner-->
                    <a class="left carousel-control" href="#carousselSerieLike" data-slide="prev"></a>
                    <a class="right carousel-control" href="#carousselSerieLike" data-slide="next"></a>
                </div>
                <!--/myCarousel-->
            </div>
            <!--/well-->
        </div>
    </div>
    <div class="episodeVue">
        <h3>Mes épisodes vus</h3>
        <hr>
        <?php
        $seriesListFinal = "";
        $urlBase = "https://image.tmdb.org/t/p/w500";
        $count = 0;
        $ligne = "<div class='row'>";
        foreach ($encours as $s) {
            $urlImage = $urlBase . $s->poster_path;
            if ($s->poster_path == null) {
                $urlImage =  URL::to('/') ."/img/unknow.png";
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

        if(count($encours) == 0) $seriesListFinal .= "Aucune série trouvée...";

        if ($count != 0) {
            $seriesListFinal .= $ligne . "</div>";
        }
        echo $seriesListFinal;

        if(!is_array($encours)) echo $encours->render();
        ?>
    </div>
</div>
<script src="js/app.js"></script>
</body>
</html>