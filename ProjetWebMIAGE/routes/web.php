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

Route::get('/', function () {
    return view('accueil');
});

Route::post('/connexion', 'ConnexionController@connect');
Route::post('/inscription','InscriptionController@inscrip');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home','HomeController@getSeries');
    Route::get('/firstconnexion','FirstConnexionController@getFilm');
});