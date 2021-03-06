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

Route::get('/', 'HomeController@index')->name('home');
Route::get('lang/{locale}', 'LocalizationController@index');

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('companies', 'CompanyController');
    Route::resource('employees', 'EmployeeController');
    Route::group(['prefix' => 'modal'], function () {
        Route::get('translate/{txt}', 'ModalController@translate');
        Route::get('companies', 'ModalController@companies');
        Route::get('employees', 'ModalController@employees');
    });
});
