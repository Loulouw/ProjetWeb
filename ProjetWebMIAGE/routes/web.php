<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'],function (){
    Route::get('/', function () {
        return view('accueil');
    });

    Route::post('/connexion', 'ConnexionController@connect');
    Route::post('/inscription','InscriptionController@inscrip');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/firstConnexion','FirstConnexionController@getSeries');
        Route::get('/home','HomeController@getSeries');
        Route::post('/home','HomeController@firstConnexionSeries');
        Route::post('/home','HomeController@recherche');
        Route::get('/home/creator/{nom}','HomeController@rechercheCreator');
        Route::get('/home/genre/{nom}','HomeController@rechercheGenre');
        Route::get('/home/companie/{nom}','HomeController@rechercheCompanie');
        Route::post('/logout', 'LogoutController@logout');
        Route::get('series/{id}', 'SeriesController@seriesInformation');
        Route::get('/rechercher',function (){
           return view('rechercher');
        });
    });
});
