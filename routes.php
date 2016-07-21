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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'publicacao'], function() {
	#gets
	Route::get('', ['as' => 'pub.lista',     'uses' => 'PublicacaoController@index']);
	Route::get('edit/{id}', ['as' => 'pub.edit',     'uses' => 'PublicacaoController@edit']);

	#posts
	Route::post('search', ['as' => 'pub.search', 'uses' =>  'PublicacaoController@search']);

	#put
	Route::put('update', ['as' => 'pub.update', 'uses' =>  'PublicacaoController@update']);

	Route::group(['prefix' => 'livro'], function() {
		#gets
		Route::get('', ['as' => 'livro.lista', 'uses' => 'LivroController@index']);
		Route::get('cadastro', ['as' => 'livro.create', 'uses' => 'LivroController@create']);
		Route::get('editar/{id}', ['as' => 'livro.edit', 'uses' =>  'LivroController@edit']);
		Route::get('delete/{id}', ['as' => 'livro.delete', 'uses' => 'LivroController@delete']);

		#posts
		Route::post('store', ['as' => 'livro.store', 'uses' =>  'LivroController@store']);

		#put
		Route::put('update', ['as' => 'livro.update', 'uses' => 'LivroController@update']);
	});

	/* Não está sendo utilizado */
	Route::group(['prefix' => 'dicionario'], function() {
		#gets
		Route::get('', ['as' => 'dic.lista', 'uses' => 'DicionarioController@index']);
		Route::get('cadastro', ['as' => 'dic.create', 'uses' => 'DicionarioController@create']);
		Route::get('editar/{id}', ['as' => 'dic.edit', 'uses' =>  'DicionarioController@edit']);

		#posts
		Route::post('store', ['as' => 'dic.store', 'uses' =>  'DicionarioController@store']);

		#put
		Route::put('update', ['as' => 'dic.update', 'uses' => 'DicionarioController@update']);
		Route::put('delete', ['as' => 'dic.delete', 'uses' => 'DicionarioController@delete']);
	});
});

Route::group(['prefix' => 'autor'], function() {
	#gets
	Route::get('', ['as' => 'autor.lista', 'uses' => 'AutorController@index']);
	Route::get('cadastro', ['as' => 'autor.create', 'uses' => 'AutorController@create']);
	Route::get('editar/{id}', ['as' => 'autor.edit', 'uses' =>  'AutorController@edit']);
	Route::get('delete/{id}', ['as' => 'autor.delete', 'uses' => 'AutorController@delete']);

	#posts
	Route::post('store', ['as' => 'autor.store', 'uses' =>  'AutorController@store']);
	Route::post('search', ['as' => 'autor.search', 'uses' =>  'AutorController@search']);

	#put
	Route::put('update', ['as' => 'autor.update', 'uses' => 'AutorController@update']);
});