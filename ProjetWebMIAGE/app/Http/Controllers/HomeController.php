<?php

namespace App\Http\Controllers;

use App\Series;
use App\SeriesGenres;
use App\UsersSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function firstConnexionSeries(Request $request)
    {
        $idusers = Auth::user()->id;
        foreach ($request->series as $s) {
            $us = new UsersSeries();
            $us->id_users = $idusers;
            $us->id_series = $s;
            $us->save();
        }
        $request->user()->firstconnexion = 0;
        $request->user()->save();

        $series = Series::paginate(30);
        return view("home", compact('series'));
    }

    public function getSeries()
    {
        $series = Series::paginate(30);
        return view("home", compact('series'));
    }

    public function recherche(Request $request)
    {
        $nomSerie = $request->NomSerie;
        $nomCreateur = $request->NomCreateur;
        $genre = $request->Genre;
        $compagnie = $request->Companie;
        $series = Series::select('series.poster_path','series.id','series.original_name','series.overview')
            ->join('seriescreators', 'seriescreators.series_id', '=', 'series.id')
            ->join('seriescompanies', 'seriescompanies.series_id', '=', 'series.id')
            ->join('seriesgenres', 'seriesgenres.series_id', '=', 'series.id')
            ->join('creators', 'creators.id', '=', 'seriescreators.creator_id')
            ->join('genres', 'genres.id', '=', 'seriesgenres.genre_id')
            ->join('companies', 'companies.id', '=', 'seriescompanies.company_id')
            ->where('creators.name', "like", "%$nomCreateur%")
            ->where('series.name', "like", "%$nomSerie%")
            ->where('genres.name', "like", "%$genre%")
            ->where('companies.name', "like", "%$compagnie%")
            ->groupby('series.poster_path','series.id','series.original_name','series.overview')
            ->paginate(30);

        return view("home", compact('series'));
    }

    public function rechercheCreator($nom){
        $series = Series::select('series.poster_path','series.id','series.original_name','series.overview')
            ->join('seriescreators', 'seriescreators.series_id', '=', 'series.id')
            ->join('creators', 'creators.id', '=', 'seriescreators.creator_id')
            ->where('creators.name', "like", "%$nom%")
            ->groupby('series.poster_path','series.id','series.original_name','series.overview')
            ->paginate(30);
        return view("home",compact('series'));
    }

    public function rechercheGenre($nom){
        $series = Series::select('series.poster_path','series.id','series.original_name','series.overview')
            ->join('seriesgenres', 'seriesgenres.series_id', '=', 'series.id')
            ->join('genres', 'genres.id', '=', 'seriesgenres.genre_id')
            ->where('genres.name', "like", "%$nom%")
            ->groupby('series.poster_path','series.id','series.original_name','series.overview')
            ->paginate(30);
        return view("home",compact('series'));
    }

    public function rechercheCompanie($nom){
        $series = Series::select('series.poster_path','series.id','series.original_name','series.overview')
            ->join('seriescompanies', 'seriescompanies.series_id', '=', 'series.id')
            ->join('companies', 'companies.id', '=', 'seriescompanies.company_id')
            ->where('companies.name', "like", "%$nom%")
            ->groupby('series.poster_path','series.id','series.original_name','series.overview')
            ->paginate(30);
        return view("home",compact('series'));
    }

    public function getSeriesSuggestion(){
        $idSerieFromUsersseriesSQL = UsersSeries::where('id_users','=',Auth::user()->id)->get();
        $idSerieFromUsersseries = array();
        foreach ($idSerieFromUsersseriesSQL as $ids) array_push($idSerieFromUsersseries,$ids->id_series);

        $countSeriesID = SeriesGenres::whereIn('series_id',$idSerieFromUsersseriesSQL)
                                        ->groupBy('genre_id')
                                        ->get();


        $genresIDCountSeriesID = SeriesGenres::select('genre_id');


        $test = DB::select("SELECT * FROM `series`as s inner join seriesgenres as sg ON s.id=SG.series_id WHERE `genre_id`IN (SELECT `genre_id`FROM `seriesgenres` WHERE `series_id`in (SELECT id_series FROM `usersseries`WHERE `id_users`=2) group by `genre_id`having count(`series_id`)=(SELECT MAX(nb_series2) FROM (SELECT `genre_id`, count(`series_id`)as nb_series2 FROM `seriesgenres` WHERE `series_id`in (SELECT id_series FROM `usersseries`WHERE `id_users`=2) group by `genre_id`having count(`series_id`))as max_nb)) order by RAND()");
        dd($test);
        return view('home');
    }
}
