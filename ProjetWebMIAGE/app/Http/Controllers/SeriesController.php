<?php

namespace App\Http\Controllers;

use App\Actors;
use App\Companies;
use App\Creators;
use App\Episodes;
use App\Genres;
use App\personnal\Episode;
use App\personnal\Season;
use App\personnal\Serie;
use App\Seasons;
use App\Series;
use App\UsersEpisodes;
use App\UsersSeries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * Class SeriesController
 *
 * Controller contenant les méthodes pour la page Serie
 *
 * @package App\Http\Controllers
 */
class SeriesController extends Controller
{
    /**
     * Recupère toutes les informations d'une série
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seriesInformation($id)
    {
        $serie = Series::find($id);
        //On vérifie que l'id correspond
        if (preg_match('#^[0-9]+$#', $id) and $serie != null) {

            //On récupère les saisons
            $seasons = Seasons::join('seriesseasons', 'seriesseasons.season_id', "=", "seasons.id")
                ->where("seriesseasons.series_id", "=", "$id")
                ->orderBy("seasons.number", "asc")
                ->get();

            $listeSeasons = array();
            //On parcours les saisons
            foreach ($seasons as $s) {

                //On récupère les épisodes
                $episodes = Episodes::join('seasonsepisodes', 'seasonsepisodes.episode_id', '=', 'episodes.id')
                    ->where("seasonsepisodes.season_id", "=", "$s->id")
                    ->orderBy('episodes.number', 'asc')
                    ->get();
                $listeEpisodes = array();

                //On parcours les épisodes
                foreach ($episodes as $e) {

                    //On récupère les acteurs
                    $actors = Actors::join('episodesactors', 'episodesactors.actor_id', "=", "actors.id")
                        ->where("episodesactors.episode_id", "=", "$e->id")
                        ->get();

                    $vue = false;
                    $ue = UsersEpisodes::where('user_id', '=', Auth::user()->id)->where('episode_id', '=', $e->id)->first();
                    if ($ue != null) $vue = true;

                    array_push($listeEpisodes, new Episode($e, $actors, $vue));
                }
                array_push($listeSeasons, new Season($s, $listeEpisodes));
            }


            //Si l'utilisateur aime la série
            $like = false;
            if (UsersSeries::where('id_users', '=', Auth::user()->id)->where('id_series', '=', $id)->first() != null) $like = true;

            //Genres de la série
            $genres = Genres::join('seriesgenres', 'seriesgenres.genre_id', '=', 'genres.id')
                ->where("seriesgenres.series_id", "=", "$id")
                ->get();

            //Compagnies
            $companies = Companies::join('seriescompanies', 'seriescompanies.company_id', '=', 'companies.id')
                ->where("seriescompanies.series_id", "=", "$id")
                ->get();

            //Les créateurs
            $creators = Creators::join('seriescreators', "seriescreators.creator_id", "=", "creators.id")
                ->where("seriescreators.series_id", "=", "$id")
                ->get();

            $creatorsId = array();
            foreach ($creators as $c) array_push($creatorsId, $c->id);

            //La propositions de séries
            $seriesProposition = Series::join('seriescreators', 'seriescreators.series_id', '=', 'series.id')
                ->whereIn('seriescreators.creator_id', $creatorsId)
                ->where('series.id', '!=', $id)
                ->get();

            return view("series", ["serie" => new Serie($serie, $listeSeasons, $genres, $creators, $companies, $like), 'serieproposition' => $seriesProposition]);
        } else {
            return Redirect::to("/home");
        }
    }

    /**
     * Indique qu'on aime ou non une série
     * @param $id
     * @return mixed
     */
    public function seriesLike($id)
    {
        $u = UsersSeries::where('id_users', '=', Auth::user()->id)->where('id_series', '=', $id)->first();
        if ($u != null) {
            $u->delete();
        } else {
            $us = new UsersSeries();
            $us->id_users = Auth::user()->id;
            $us->id_series = $id;
            $us->save();
        }
        return Redirect::to("/series/" . $id);
    }

    /**
     * Indique qu'on a vu un episode d'une série
     * @param $idSerie
     * @param $idEpisode
     * @return mixed
     */
    public function episodeVue($idSerie, $idEpisode)
    {
        $s = UsersEpisodes::where('user_id', '=', Auth::user()->id)->where('episode_id', "=", $idEpisode)->first();
        if ($s != null) {
            $s->delete();
        } else {
            $s = new UsersEpisodes();
            $s->user_id = Auth::user()->id;
            $s->episode_id = $idEpisode;
            $s->save();
        }
        return Redirect::to("/series/" . $idSerie);
    }
}
