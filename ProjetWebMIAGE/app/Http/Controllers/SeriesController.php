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
use Illuminate\Support\Facades\Redirect;

class SeriesController extends Controller
{
    public function seriesInformation($id)
    {
        $serie = Series::find($id);
        if (preg_match('#^[0-9]+$#', $id) and $serie != null) {
            $seasons = Seasons::join('seriesseasons', 'seriesseasons.season_id', "=", "seasons.id")
                ->where("seriesseasons.series_id", "=", "$id")
                ->orderBy("seasons.number","asc")
                ->get();

            $listeSeasons = array();
            foreach ($seasons as $s) {
                $episodes = Episodes::join('seasonsepisodes', 'seasonsepisodes.episode_id', '=', 'episodes.id')
                    ->where("seasonsepisodes.season_id", "=", "$s->id")
                    ->orderBy('episodes.number','asc')
                    ->get();
                $listeEpisodes = array();
                foreach ($episodes as $e) {
                    $actors = Actors::join('episodesactors', 'episodesactors.actor_id', "=", "actors.id")
                        ->where("episodesactors.episode_id", "=", "$e->id")
                        ->get();
                    array_push($listeEpisodes,new Episode($e,$actors));
                }
                array_push($listeSeasons,new Season($s,$listeEpisodes));
            }

            $genres = Genres::join('seriesgenres', 'seriesgenres.genre_id', '=', 'genres.id')
                ->where("seriesgenres.series_id", "=", "$id")
                ->get();

            $creators = Creators::join('seriescreators', "seriescreators.creator_id", "=", "creators.id")
                ->where("seriescreators.series_id", "=", "$id")
                ->get();

            $companies = Companies::join('seriescompanies', 'seriescompanies.company_id', '=', 'companies.id')
                ->where("seriescompanies.series_id", "=", "$id")
                ->get();


            return view("series", ["serie" => new Serie($serie,$listeSeasons,$genres,$creators,$companies)]);
        } else {
            return Redirect::to("/home");
        }
    }
}
