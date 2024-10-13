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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/* Auth */
Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');

/* Clientes */
Route::get('wp_clientes', 'ClienteController@getWPClientes');
Route::get('clientesIngresados', 'ClienteController@getClientesIngresados');
Route::post('migrarClientes', 'ClienteController@migrarClientes');
Route::post('enviarCotizacion', 'ClienteController@enviarCotizacion');

/* Tipo Tramites */
Route::get('conceptos', 'ClienteController@getConceptos');

