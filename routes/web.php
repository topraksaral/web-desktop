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
Route::group(['middleware' => ['mainView']], function(){
	Route::get('/', function () {
	    return view('welcome');
	});
});
Route::group(['namespace' => 'System', 'prefix' => 'system'], function (){

	Route::group(['middleware' => ['mainView']], function(){
		Route::post('/check-extension', ['as' => 'call.extension.check.n', 'uses' => 'ExtensionController@postCheckExtension']);
		Route::post('/check-extension/{ext}', ['as' => 'call.extension.check', 'uses' => 'ExtensionController@postCheckExtension']);

		Route::post('/find-extension', ['as' => 'call.extension.find', 'uses' => 'ExtensionController@postExtensionForFile']);

		Route::get('/download-file', ['as' => 'file.download', 'uses' => 'FileController@getDownload']);

		Route::get('/backgrounds', ['as' => 'system.background', 'uses' => 'FileController@getBackgrounds']);
	});

	Route::get('/extension', ['as' => 'call.extension.n', 'uses' => 'ExtensionController@runExtension']);
	Route::get('/extension/{ext}', ['as' => 'call.extension', 'uses' => 'ExtensionController@runExtension']);
	Route::post('/extension/{ext}', ['uses' => 'ExtensionController@runExtension']);

	Route::get('/extension-statics/{ext}/{type}/{all}', ['as' => 'call.extension.static', 'uses' => 'ExtensionController@getExtensionStaticFile'])->where('all', '.*');
});
