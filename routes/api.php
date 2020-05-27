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

/* Autenticacion de usuarios
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('articles', 'ArticleController@index');
    Route::get('articles/{article}', 'ArticleController@show');
    Route::post('articles', 'ArticleController@store');
    Route::put('articles/{article}', 'ArticleController@update');
    Route::delete('articles/{article}', 'ArticleController@delete');
});
 */

//Route::middleware('auth:api')->get('/order', 'OrderController@index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
  Route::get('order', 'OrderController@index');
});

Route::post('login', 'Auth\LoginController@login')->name('login');;
Route::post('logout', 'Auth\LoginController@logout');

//Agregamos nuestra ruta al controller de pizzas
Route::resource('pizza', 'PizzaController');
Route::get('size', 'SizeController@index');
Route::get('parameter', 'ParameterController@index');

Route::post('order', 'OrderController@create');
//Route::get('/order', 'OrderController@index');
//Route::get('/order/{id}', 'OrderController@show');

