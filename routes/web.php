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

Route::prefix('idep-report')->group(function() {
    Route::get('/list', 'IdepReportController@showListIdepReport');
    Route::post('/create-log', 'IdepReportController@postCreateForm');

    Route::get('/data-employee', 'IdepReportController@getDataEmployeeList');
    Route::post('/data-log', 'IdepReportController@getDataIdepLog');
});
