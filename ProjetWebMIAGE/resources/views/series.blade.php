<?php

function decoreList($list, $path)
{
    $listf = "";
    foreach ($list as $l) {
        if ($path != null) {
            $listf .= "<a href='" . url('/home') . "/" . $path . "/" . $l->name . "'>" . $l->name . "</a> - ";
        } else {
            $listf .= $l->name . " - ";
        }
    }
    return substr($listf, 0, -3);
}


$urlCoeur = url('/') . "/img/dislike.png";
if ($serie->getLike()) $urlCoeur = url('/') . "/img/like.png";
$urlCoeur = "<a href='" . url('/series') . "/like/" . $serie->getSerie()->id . "'><img src='" . $urlCoeur . "' alt='Coeur'/></a>";

$nomSerie = $serie->getSerie()->original_name;

$dateSortieSerie = $serie->getSerie()->first_air_date;

$descriptionSerie = $serie->getSerie()->overview;

$urlImage = url('/') . "/img/unknow.png";
if ($serie->getSerie()->poster_path != null) {
    $urlImage = "https://image.tmdb.org/t/p/w500" . $serie->getSerie()->poster_path;
}

$encours = "<button type='button' class='btn btn-info'>En production</button>";
if ($serie->getSerie()->in_production == 0) {
    $encours = "<button type='button' class='btn btn-success'>Terminée</button>";
}

$genrestexte = decoreList($serie->getGenres(), "genre");

$creatorstexte = decoreList($serie->getCreators(), "creator");

$companiestexte = decoreList($serie->getCompanies(), "companie");

$listSeason = "";
$contentTabSeason = "";
$countSeason = 0;
foreach ($serie->getSeasons() as $season) {
    $seasonModel = $season->getSeason();
    $countSeason++;

    $nameOfSeason = "Season " . $seasonModel->number;
    if ($seasonModel->name != null && strcmp(trim($seasonModel->name), '')) $nameOfSeason = $seasonModel->name;

    if ($countSeason == 1) {
        $listSeason .= "<li class='active'><a href='#tabPaneSeason" . $seasonModel->number . "' data-toggle='tab'>" . $nameOfSeason . "</a></li>";
        $contentTabSeason .= "<div class='tab-pane active' id='tabPaneSeason" . $seasonModel->number . "'>";
    } else {
        $listSeason .= "<li><a href='#tabPaneSeason" . $seasonModel->number . "' data-toggle='tab'>" . $nameOfSeason . "</a></li>";
        $contentTabSeason .= "<div class='tab-pane' id='tabPaneSeason" . $seasonModel->number . "'>";
    }
    $contentTabSeason .= "<p>" . $seasonModel->overview . "</p><p>Date de diffusion : " . $seasonModel->air_date . "</p>";

    $contentEpisode = "";
    $countEpisode = 0;
    foreach ($season->getEpisodes() as $episode) {
        $countEpisode++;
        $episodeModel = $episode->getEpisode();
        $urlImageEpisode = url("/") . "/img/unknow_episode.png";

        if ($episodeModel->still_path != null) $urlImageEpisode = "https://image.tmdb.org/t/p/w500" . $episodeModel->still_path;

        if ($countEpisode == 1) $contentEpisode .= "<div class='wrapper'>";


        $buttonVue = "<a href='". url('/series') . "/vue/" . $serie->getSerie()->id."/".$episodeModel->id."' class='btn btn-danger' role='button'>Non vue</a>";
        if($episode->getVue()){
            $buttonVue = "<a href='".url('/series') . "/vue/" . $serie->getSerie()->id."/".$episodeModel->id."' class='btn btn-success' role='button'>Vue</a>";
        }

        $contentEpisode .= "<div class='thumbnail episodeSeason'>"
            . "<img class='mg-rounded img-responsive' src='" . $urlImageEpisode . "' alt='Episode" . $episodeModel->number . "'>"
            . "<div class='caption'>"
            . "<h3 class='text-left'>" . $episodeModel->number . " - " . $episodeModel->name . " " . $buttonVue ."</h3>"
            . "<p class='text-left text-justify'>" . $episodeModel->overview . "</p>"
            . "<p class='text-left actorsEpisode'>Acteurs : " . decoreList($episode->getActors(), null) . "</p>"
            . "</div></div>";

        if ($countEpisode == 2) {
            $contentEpisode .= "</div>";
            $countEpisode = 0;
        }
    }
    if ($countEpisode != 0) {
        $contentEpisode .= "</div>";
    }

    $contentTabSeason .= $contentEpisode . "</div>";

    $contentTabProposition = "";
    $countProposition = 0;
    $firstProposition = true;
    foreach ($serieproposition as $sp) {
        $countProposition++;
        if ($countProposition == 1) {
            if ($firstProposition) {
                $contentTabProposition .= "<div class='item active'>";
                $firstProposition = false;
            } else {
                $contentTabProposition .= "<div class='item'>";
            }
            $contentTabProposition .= "<div class='row'>";
        }

        $urlImageEpisodeProposition = url("/") . "/img/unknow_episode.png";
        if ($sp->backdrop_path != null) $urlImageEpisodeProposition = "https://image.tmdb.org/t/p/w500" . $sp->backdrop_path;

        $contentTabProposition .= " <div class='col-sm-3'>
                                        <a href='" . url("series/$sp->id") . "' class='thumbnail'>
                                            <img src='" . $urlImageEpisodeProposition . "' alt='" . $sp->original_name . "' class='img-responsive'>
                                            <div class='textCarousselProposition'>" . $sp->original_name . "</div>
                                        </a>
                                    </div>";


        if ($countProposition == 4) {
            $contentTabProposition .= "</div></div>";
            $countProposition = 0;
        }
    }
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
    <div class="row">
        <div class="col-md-3"><img src="{{$urlImage}}" class="img-responsive img-rounded" alt="inconnu"></div>
        <div class="col-md-9 text-left">
            <div class="row">
                <div id="titreSeries">{!!$urlCoeur!!} {{$nomSerie}} {!! $encours !!}</div>
            </div>
            <br>
            <div class="row">
                {{$dateSortieSerie}} | {!!$genrestexte!!}
            </div>
            <div class="row">
                <br>
                <div id="descriptionSerie" class="text-justify">{{$descriptionSerie}}</div>
            </div>
            <div class="row">
                <br>
                Créateur(s) : {!!$creatorstexte!!}
            </div>
            <div class="row">
                <br>
                Companie(s) : {!!$companiestexte!!}
            </div>
        </div>
    </div>

    <ul id="seasonSeriesTabPane" class="nav nav-tabs">
        {!! $listSeason !!}
    </ul>

    <div class="tab-content ">
        {!! $contentTabSeason !!}
    </div>

    <div class="propositionseries">
        <hr>
        <h3>Proposition de séries</h3>
        <div class="col-md-12">
            <div class="well">
                <div id="carousselSerieProposition" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner center-block">
                        <!--/item-->
                        {!!$contentTabProposition!!}
                    </div>
                    <!--/carousel-inner-->
                    <a class="left carousel-control" href="#carousselSerieProposition" data-slide="prev"></a>
                    <a class="right carousel-control" href="#carousselSerieProposition" data-slide="next"></a>
                </div>
                <!--/myCarousel-->
            </div>
            <!--/well-->

        </div>
    </div>

</div>
<script src="{{ URL::to('/') }}/js/app.js"></script>
</body>
</html>