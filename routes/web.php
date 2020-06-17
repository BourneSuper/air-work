<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group( [ 'middleware' => 'auth' ], function(){
    Route::get( '/project/all', 'ProjectController@all' );
    Route::get( '/project/asOwner', 'ProjectController@asOwner' );
    Route::get( '/project/asMember', 'ProjectController@asMember' );
    Route::get( '/project/createIndex', 'ProjectController@createIndex' );
    Route::post( '/project/create', 'ProjectController@create' );
    Route::get( '/project/boardIndex/{projectId}', 'ProjectController@boardIndex' );
    Route::get( '/project/settingIndex/{projectId}', 'ProjectController@settingIndex' );
    Route::post( '/project/update', 'ProjectController@update' );
    
    Route::post( '/task/update', 'TaskController@update' );
    Route::post( '/task/create', 'TaskController@create' );
    Route::post( '/task/delete', 'TaskController@delete' );
    
    Route::post( '/flowProcess/update', 'FlowProcessController@update' );
    Route::post( '/flowProcess/create', 'FlowProcessController@create' );
    Route::post( '/flowProcess/delete', 'FlowProcessController@delete' );
    
    
    
    Route::post( '/user/optionList', 'UserController@optionList' );
    
} );

