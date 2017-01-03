<?php

namespace App\Http\Controllers;

use App\Series;
use App\UsersSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class HomeController
 *
 * Controller contenant les méthdodes pour la page d'accueil connectée
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * Enregistre les choix du nouvel utilisateur  récupères toutes les séries par pagination de 30
     *
     * @param Request $request Continet les séries que l'utilisateur a choisi
     * @return vue home avec les séries
     */
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

    /**
     * récupères toutes les séries par pagination de 30
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeries()
    {
        $series = Series::paginate(30);
        return view("home", compact('series'));
    }

    /**
     * Recherche la série en fonction du nom de la série, du créateur, du genre et de la compagnie
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recherche(Request $request)
    {
        $nomSerie = $request->NomSerie;
        $nomCreateur = $request->NomCreateur;
        $genre = $request->Genre;
        $compagnie = $request->Companie;
        $series = Series::select('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->join('seriescreators', 'seriescreators.series_id', '=', 'series.id')
            ->join('seriescompanies', 'seriescompanies.series_id', '=', 'series.id')
            ->join('seriesgenres', 'seriesgenres.series_id', '=', 'series.id')
            ->join('creators', 'creators.id', '=', 'seriescreators.creator_id')
            ->join('genres', 'genres.id', '=', 'seriesgenres.genre_id')
            ->join('companies', 'companies.id', '=', 'seriescompanies.company_id')
            ->where('creators.name', "like", "%$nomCreateur%")
            ->where('series.original_name', "like", "%$nomSerie%")
            ->where('genres.name', "like", "%$genre%")
            ->where('companies.name', "like", "%$compagnie%")
            ->groupby('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->paginate(30);

        return view("home", compact('series'));
    }

    /**
     * Recherche par créateur
     * @param $nom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rechercheCreator($nom)
    {
        $series = Series::select('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->join('seriescreators', 'seriescreators.series_id', '=', 'series.id')
            ->join('creators', 'creators.id', '=', 'seriescreators.creator_id')
            ->where('creators.name', "like", "%$nom%")
            ->groupby('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->paginate(30);
        return view("home", compact('series'));
    }

    /**
     * Recherche par genre
     * @param $nom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rechercheGenre($nom)
    {
        $series = Series::select('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->join('seriesgenres', 'seriesgenres.series_id', '=', 'series.id')
            ->join('genres', 'genres.id', '=', 'seriesgenres.genre_id')
            ->where('genres.name', "like", "%$nom%")
            ->groupby('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->paginate(30);
        return view("home", compact('series'));
    }

    /**
     * Recherche par Compagnie
     * @param $nom
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rechercheCompanie($nom)
    {
        $series = Series::select('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->join('seriescompanies', 'seriescompanies.series_id', '=', 'series.id')
            ->join('companies', 'companies.id', '=', 'seriescompanies.company_id')
            ->where('companies.name', "like", "%$nom%")
            ->groupby('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->paginate(30);
        return view("home", compact('series'));
    }

    /**
     * Obtenir les suggestions en fonction du genre le plus populaire parmis les choix de l'utilisateur
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeriesSuggestion()
    {
        $series = DB::select("SELECT * FROM `series`as s 
        inner join seriesgenres as sg ON s.id=SG.series_id
        WHERE `genre_id`IN (SELECT `genre_id`FROM `seriesgenres`
                            WHERE `series_id`in (SELECT id_series FROM `usersseries`
                                                  WHERE `id_users`=" . Auth::user()->id . ")
                            group by `genre_id`,`series_id`
                            having count(`series_id`) = (SELECT MAX(nb_series2) FROM 
                            (SELECT `genre_id`, count(`series_id`)as nb_series2 FROM `seriesgenres`
                            WHERE `series_id`in (SELECT id_series FROM `usersseries`
                            WHERE `id_users`=" . Auth::user()->id . ")
                            group by `genre_id`, `series_id`
                            having count(`series_id`))as max_nb))
        order by RAND() LIMIT 30");

        return view('home', compact('series'));
    }
}
