<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    @include('includes.header')
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('home')}}">FlixNet</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{url('home')}}">Accueil</a></li>
                <li><a href="#">Ma Bibliothèque</a></li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Rechercher</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ Auth::user()->name }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Mon Compte</a></li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnection</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid text-center">
    <?php

    $seriesListFinal = "";
    $urlBase = "https://image.tmdb.org/t/p/w500";
    $count = 0;
    $ligne = "<div class='row'>";
    foreach ($series as $s) {
        $urlImage = $urlBase. $s->poster_path;
        if($s->poster_path == null){
            $urlImage = "img/unknow.png";
        }
        $count++;
        $ligne .= "<div class='col-xs-2'>
<div class='thumbnail imgSeriesHome'>
<img idseries='" . $s->id . "' class='mg-rounded img-responsive' src='" . $urlImage . "' alt='" . $s->original_name . "'>
<div class='caption'>
        <h3>" . $s->original_name . "</h3>
        <p>" . substr($s->overview, 0, 100) . "...</p>
    </div>
</div>
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