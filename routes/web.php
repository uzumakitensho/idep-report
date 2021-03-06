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
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('idep-report')->group(function() {
    Route::get('/list', 'IdepReportController@showListIdepReport');
    Route::post('/create-log', 'IdepReportController@postCreateForm');
    Route::post('/edit-log/{uuid}', 'IdepReportController@postEditForm');
    Route::post('/delete-log/{uuid}', 'IdepReportController@postDeleteForm');

    Route::get('/data-employee', 'IdepReportController@getDataEmployeeList');
    Route::get('/data-type', 'IdepReportController@getDataIdepTypeList');
    Route::post('/data-log', 'IdepReportController@getDataIdepLog');
});

Route::prefix('employee')->group(function() {
    Route::get('/list', 'EmployeeController@showListEmployee');
    Route::post('/import', 'EmployeeController@importListEmployee');
});

Route::prefix('periode')->group(function() {
    Route::get('/list', 'PeriodeController@showListPeriode');
});
