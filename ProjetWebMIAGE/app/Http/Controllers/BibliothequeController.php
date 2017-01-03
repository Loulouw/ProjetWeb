<?php

namespace App\Http\Controllers;

use App\Series;
use App\UsersEpisodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class BibliothequeController
 *
 * Controller contenant les méthodes pour la page bibliothèque
 *
 * @package App\Http\Controllers
 */
class BibliothequeController extends Controller
{
    /**
     * Retourne La vue bibliothèque avec les séries aimées et en cours de visionage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeriesAndEpisode()
    {
        $seriesLike = Series::join('usersseries', 'usersseries.id_series', '=', 'series.id')
            ->where('usersseries.id_users', '=', Auth::user()->id)
            ->get();

        $encours=DB::select("select series.poster_path, series.id, series.original_name, series.overview from series
inner join seriesseasons on seriesseasons.series_id = series.id
inner join seasonsepisodes on seasonsepisodes.season_id = seriesseasons.season_id
where seasonsepisodes.episode_id in (select usersepisodes.episode_id from usersepisodes WHERE usersepisodes.user_id = ".Auth::user()->id.") group by series.poster_path, series.id, series.original_name, series.overview");

        return view('bibliotheque',['seriesLike' => $seriesLike,'encours' => $encours]);
    }
}
