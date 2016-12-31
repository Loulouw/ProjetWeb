<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BibliothequeController extends Controller
{
    public function getSeriesAndEpisode()
    {
        $seriesLike = Series::join('usersseries', 'usersseries.id_series', '=', 'series.id')
            ->where('usersseries.id_users', '=', Auth::user()->id)
            ->get();

        return view('bibliotheque',['seriesLike' => $seriesLike]);
    }
}
