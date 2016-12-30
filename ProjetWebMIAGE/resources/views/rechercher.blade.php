<?php
$contentSelectGenres = "";
foreach ($genres as $g) {
    $contentSelectGenres .= "<option>" . $g->name . "</option>";
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
    <form class="form-horizontal" id="recherche" role='form' action="{{action('HomeController@recherche')}}"
          method='post' name='rechercheForm'>
        {{ csrf_field() }}
        <fieldset>

            <!-- Form Name -->
            <legend>Rechercher</legend>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="NomSerie">Nom Série</label>
                <div class="col-md-4">
                    <input id="NomSerie" name="NomSerie" type="text" placeholder="" class="form-control input-md">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="NomActeur">Nom Createur</label>
                <div class="col-md-4">
                    <input id="NomCreateur" name="NomCreateur" type="text" placeholder="" class="form-control input-md">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="Genre">Genre</label>
                <div class="col-md-4">
                    <select class="form-control selectGenre" name="Genre" datatype="text" id="Genre">
                        <option></option>
                        {!!$contentSelectGenres!!}
                    </select>
                </div>
                <!--<label class="col-md-4 control-label" for="Genre">Genre</label>
                <div class="col-md-4">
                    <input id="Genre" name="Genre" type="text" placeholder="" class="form-control input-md">

                </div>-->
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="Companie">Companie</label>
                <div class="col-md-4">
                    <input id="Companie" name="Companie" type="text" placeholder="" class="form-control input-md">

                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="rechercher"></label>
                <div class="col-md-4">
                    <button id="rechercher" name="rechercher" class="btn btn-success btn-lg">Rechercher</button>
                </div>
            </div>

        </fieldset>
    </form>

</div>
<script src="js/app.js"></script>
</body>
</html>