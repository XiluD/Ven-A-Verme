<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route for creating an Admin account
Route::get('admin', 'AdminsController@create');

//Basic routes without authentication needed
Route::get('/provsMunsBasic', 'DevApisController@getMunsEV');

Route::get('/evOrder/{provincia}', 'DevApisController@getMunsFromProvEVOrdered');

//Routes with API_AUTH Middleware
Route::middleware('api_auth')->group(function () {
    
    Route::get('/tripCard{cardLink?}{api_token?}', 'PythonController@getTripCard');

    Route::get('/trip/{provincia}/{municipio}{api_token?}', 'PythonController@getTrip');
    
    Route::get('/ideaCard{cardLink?}{api_token?}', 'PythonController@getIdeaCard');
    /*
    Route format: 
    127.0.0.1:8000/api/ideaCard?cardLink=https://www.idealista.com/inmueble/32188405/&api_token=REQMvIh1TGhJeAwA8nwbbeV8r2cse0Aa8WpjY2kzd8gw6uf4QqAJSeNlFM6cKT06qSGhD0T40RCftczI
    */
    
    Route::get('/idea/{provincia}/{municipio}{api_token?}', 'PythonController@getIdea');
});