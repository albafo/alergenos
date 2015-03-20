<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
Route::post('menu/edit/{id}', 'MenuController@edit');
Route::get('menu/destroy/{id}', 'MenuController@destroy');
Route::post('categoria/store/{id}', 'CategoriaController@store');
Route::post('categoria/update/{id_menu}/{id_cat}', 'CategoriaController@update');
Route::post('categoria/reordenar/{id_menu}/', 'CategoriaController@reordenar');
Route::post('categoria/destroy/{id_menu}/{id_cat}', 'CategoriaController@destroy');
Route::get('plato/show/{id_cat}', 'PlatoController@show');
Route::post('plato/store/{id_cat}', 'PlatoController@store');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
    'menu'  =>  'MenuController'
]);
//Route::post('menu/edit/{id}', 'MenuController@edit');