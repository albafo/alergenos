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
Route::get('categoria/idiomas/{id_cat}', 'CategoriaController@idiomas');
Route::get('plato/show/{id_cat}', 'PlatoController@show');
Route::post('plato/store/{id_cat}', 'PlatoController@store');
Route::get('plato/datos/{id_plato}/{id_cat}', 'PlatoController@datos');
Route::post('plato/update/{id_plato}', 'PlatoController@update');
Route::post('plato/update/{id_plato}/{id_cat}', 'PlatoController@update');
Route::post('plato/destroy/{id_plato}/{id_cat}', 'PlatoController@destroy');
Route::post('plato/reordenar/{id_cat}', 'PlatoController@reordenar');
Route::get('plato/ingredientes/{id_plato}', 'PlatoController@showIngredientes');
Route::get('plato/idiomas/{id_plato}', 'PlatoController@idiomas');
Route::get('plato/all', 'PlatoController@all');


Route::get('ingrediente/buscar-letra/{char}', 'IngredienteController@showByChar');
Route::get('ingrediente/buscar-letra-alerg/{char}', 'IngredienteController@showByCharAlerg');
Route::get('ingrediente/customAlerg/{id_menu}/{id_ingrediente}', 'IngredienteController@getAlergeno');

Route::post('plato/add-ingrediente/{id_menu}/{id_plato}/{id_ingrediente}', 'PlatoController@addIngrediente');
Route::post('plato/eliminar-ingrediente/{id_plato}/{id_ingrediente}', 'PlatoController@removeIngrediente');
Route::get('admin/alergenos/nuevo', 'AlergenoController@create');
Route::post('admin/alergenos/nuevo', 'AlergenoController@store');
Route::get('admin/alergenos/editar/{id}', 'AlergenoController@edit');
Route::post('admin/alergenos/editar/{id}', 'AlergenoController@update');
Route::get('admin/alergenos/eliminar/{id}', 'AlergenoController@destroy');
Route::post('ingredientes/nuevo',  [
    'middleware' => 'admin',
    'uses' => 'IngredienteController@store'
]);
Route::get('ingredientes/find', 'IngredienteController@find');
Route::get('ingredientes/findWithAlerg', 'IngredienteController@findWithAlerg');
Route::post('ingredientes/editar-visibilidad/{id_plato}/{id_ingrediente}', 'IngredienteController@editarVisibilidad');
Route::get('ingredientes/show/{id}', 'IngredienteController@show');
Route::post('ingredientes/editar/{id}',  [
    'middleware' => 'admin',
    'uses' => 'IngredienteController@update'
]);
Route::get('ingredientes/eliminar/{id}', [
    'middleware' => 'admin',
    'uses' => 'IngredienteController@destroy'
]);
Route::get('admin/usuarios/datatable', [
    'middleware' => 'admin',
    'uses' =>'UsuarioController@usuariosDT'
]);
Route::post('ingredientes/peticion', 'IngredienteController@peticion');
Route::get('admin/usuario/{id}', 'UsuarioController@edit');
Route::get('usuario/datos',  'UsuarioController@edit');
Route::post('usuario/datos',  'UsuarioController@update');
Route::get('iconos/{id}/{name}',  'IconoController@show');

Route::get('user/renew',  'UsuarioController@renew');
Route::get('user/paid/{id}', 'UsuarioController@paid');
Route::post('user/paid/{id}', 'UsuarioController@postPaid');
Route::get('user/manual', 'UsuarioController@getManual');
Route::get('user/certificado', 'UsuarioController@getCertificado');
Route::get('user/test-certificado', 'UsuarioController@testCertificado');
Route::get('user/delete', 'UsuarioController@remove');


Route::get('admin/ticketsTable',  'TicketController@ticketsTable');
Route::get('admin/ticket/{id}',  'TicketController@getTicket');
Route::get('admin/ticket/noReaded/{id}',  'TicketController@removeReaded');
Route::get('admin/ticket/resolved/{id}',  'TicketController@resolved');
Route::get('admin/ticket/delete/{id}',  'TicketController@remove');
Route::get('idiomas',  'IdiomaController@getIndex');
Route::post('idioma/nuevo',  'IdiomaController@postNuevo');
Route::get('idioma/editar/{id}',  'IdiomaController@getEditar');
Route::get('idioma/borrar/{id}',  'IdiomaController@getBorrar');






Route::controllers([
    'tests' => 'TestsController',
    'admin'=>'AdminController',
    'tecnico'=>'TecnicoController',
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
    'menu'  =>  'MenuController'
 
]);
//Route::post('menu/edit/{id}', 'MenuController@edit');