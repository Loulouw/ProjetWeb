<?php

namespace App\Http\Controllers;

use App\Series;
use App\UsersEpisodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BibliothequeController extends Controller
{
    public function getSeriesAndEpisode()
    {
        $seriesLike = Series::join('usersseries', 'usersseries.id_series', '=', 'series.id')
            ->where('usersseries.id_users', '=', Auth::user()->id)
            ->get();

        /*$ue = UsersEpisodes::where('user_id','=',Auth::user()->id)->get();
        $encours = Series::select('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->join('seriesseasons','seriesseasons.series_id','=','series.id')
            ->join('seasonsepisodes','seasonsepisodes.season_id','=','seriesseasons.season_id')
            ->whereIn('seasonsepisodes.episode_id',$ue)
            ->groupby('series.poster_path', 'series.id', 'series.original_name', 'series.overview')
            ->paginate(30);*/
        $encours=DB::select("select series.poster_path, series.id, series.original_name, series.overview from series
inner join seriesseasons on seriesseasons.series_id = series.id
inner join seasonsepisodes on seasonsepisodes.season_id = seriesseasons.season_id
where seasonsepisodes.episode_id in (select usersepisodes.episode_id from usersepisodes WHERE usersepisodes.user_id = ".Auth::user()->id.") group by series.poster_path, series.id, series.original_name, series.overview");

        return view('bibliotheque',['seriesLike' => $seriesLike,'encours' => $encours]);
    }
}
