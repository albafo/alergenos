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

Route::get('/', function(){
    return redirect('home');
});
Route::get('home', 'HomeController@index');
Route::post('menu/edit/{id}', 'MenuController@edit');
Route::get('menu/destroy/{id}', 'MenuController@destroy');
Route::post('categoria/store/{id}', 'CategoriaController@store');
Route::post('categoria/update/{id_menu}/{id_cat}', 'CategoriaController@update');
Route::post('categoria/reordenar/{id_menu}/', 'CategoriaController@reordenar');
Route::post('categoria/destroy/{id_menu}/{id_cat}', 'CategoriaController@destroy');
Route::get('plato/show/{id_cat}', 'PlatoController@show');
Route::post('plato/store/{id_cat}', 'PlatoController@store');
Route::get('plato/datos/{id_plato}', 'PlatoController@datos');
Route::post('plato/update/{id_plato}', 'PlatoController@update');
Route::post('plato/destroy/{id_plato}', 'PlatoController@destroy');
Route::post('plato/reordenar/{id_cat}', 'PlatoController@reordenar');
Route::get('plato/ingredientes/{id_plato}', 'PlatoController@showIngredientes');
Route::get('ingrediente/buscar-letra/{char}', 'IngredienteController@showByChar');
Route::get('ingrediente/buscar-letra-alerg/{char}', 'IngredienteController@showByCharAlerg');

Route::post('plato/add-ingrediente/{id_plato}/{id_ingrediente}', 'PlatoController@addIngrediente');
Route::post('plato/eliminar-ingrediente/{id_plato}/{id_ingrediente}', 'PlatoController@removeIngrediente');
Route::get('admin/alergenos/nuevo', 'AlergenoController@create');
Route::post('admin/alergenos/nuevo', 'AlergenoController@store');
Route::get('admin/alergenos/editar/{id}', 'AlergenoController@edit');
Route::post('admin/alergenos/editar/{id}', 'AlergenoController@update');
Route::get('admin/alergenos/eliminar/{id}', 'AlergenoController@destroy');
Route::post('ingredientes/nuevo', 'IngredienteController@store');
Route::get('ingredientes/find', 'IngredienteController@find');
Route::get('ingredientes/findWithAlerg', 'IngredienteController@findWithAlerg');

Route::get('ingredientes/show/{id}', 'IngredienteController@show');
Route::post('ingredientes/editar/{id}', 'IngredienteController@update');
Route::get('ingredientes/eliminar/{id}', 'IngredienteController@destroy');



Route::controllers([
    'admin'=>'AdminController',
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
    'menu'  =>  'MenuController'
 
]);
//Route::post('menu/edit/{id}', 'MenuController@edit');