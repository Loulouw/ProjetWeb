<?php

namespace App\Http\Controllers;

use App\Series;
use App\UsersSeries;
use Illuminate\Http\Request;

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
}
