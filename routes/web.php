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

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/authorized-clients-tokens', 'HomeController@GetAuthorizedClientsTokens')->name('authorized-clients-tokens');
Route::get('/clients-tokens', 'HomeController@GetClientsTokens')->name( 'clients-tokens');
Route::get('/personal-access-tokens', 'HomeController@GetPersonalAccessTokens')->name('personal-access-tokens');

Route::get('/', function(){
    return view('welcome');
});
