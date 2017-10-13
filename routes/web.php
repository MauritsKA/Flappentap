<?php

//////////////////////////// Not restricted
///// Homepage
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


/////Profile overview
Route::get('/profile', 'ProfileController@index');


///// Dashboard overview
Route::get('/dashboard', 'DashboardController@index');


///// Balances
Route::get('/balances/create', 'BalanceController@form');

Route::post('/balances/create', 'BalanceController@create');


///// Personal overview
Route::get('/personal', 'PersonalController@index');


///// Company overview
Route::get('/company', 'CompanyController@index');

Route::get('/company/create', 'CompanyController@form');

Route::post('/company/create', 'CompanyController@create');


//////////////////////////// Restricted per company 
Route::group(["middleware" => 'checkcompany'], function(){


///// Company mutation overview
Route::get('/company/{company}', 'MutationController@show');

Route::post('/company/{company}', 'MutationController@create');

    
///// Version per mutation overview
Route::get('/company/{company}/{mutation}', 'VersionController@show');
    
});
