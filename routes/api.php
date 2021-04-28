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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::get('blogs', 'BlogsController@index');
 
//Route::get('blogs/{id}', 'BlogsController@show');
 
//Route::post('blogs','BlogsController@store');
 
//Route::put('blogs/{id}','BlogsController@update');
 
//Route::delete('blogs/{id}', 'BlogsController@delete');

Route::get('admin', 'AdminsController@create');

//Route::middleware('api_auth')->get('/py{api_token?}', 'PythonController@show_py');

Route::middleware('api_auth')->group(function () {
    
    Route::get('/tripCard{api_token?}', 'PythonController@getTripCard');

    Route::get('/trip/{provincia}/{municipio}{api_token?}', 'PythonController@getTrip');
    
    Route::get('/ideaCard{api_token?}', 'PythonController@getIdeaCard');
    
    Route::get('/idea/{provincia}/{municipio}{api_token?}', 'PythonController@getIdea');
});