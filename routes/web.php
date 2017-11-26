<?php

//////////////////////////// Not restricted
///// Homepage
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

/////Facebook
Route::get('/redirect', 'SocialAuthFacebookController@redirect');

Route::get('/callback', 'SocialAuthFacebookController@callback');

/////Profile overview
Route::get('/profile', 'ProfileController@index');

Route::post('/profile/email', 'ProfileController@email');

Route::post('/profile/iban', 'ProfileController@iban');

Route::post('/profile/password', 'ProfileController@password');

///// Dashboard overview
Route::get('/dashboard', 'DashboardController@index');


///// Balances
Route::get('/balances/create', 'BalanceController@form');

Route::post('/balances/create', 'BalanceController@create');

Route::post('/balances/edit/{balance}', 'BalanceController@edit');

Route::post('/balances/users/{balance}/{user}', 'BalanceController@edituser');

///// Mutations

Route::get('/balances/{balance}', 'BalanceController@index');

Route::post('/balances/{balance}', 'MutationController@create');

Route::post('/balances/{balance}/edit/{mutation}', 'MutationController@edit');
    
Route::get('/balances/{balance}/delete/{mutation}', 'MutationController@delete');

///// Versions

Route::get('/balances/{balance}/history', 'VersionController@history');

Route::get('/balances/{balance}/{mutation}', 'VersionController@index');

///// Personal overview
Route::get('/personal', 'PersonalController@index');


///// Company overview
Route::get('/company', 'CompanyController@index');

Route::get('/company/create', 'CompanyController@form');

Route::post('/company/create', 'CompanyController@create');


//////////////////////////// Restricted per company 
Route::group(["middleware" => 'checkbalance'], function(){


///// Company mutation overview
Route::get('/company/{company}', 'MutationController@show');

Route::post('/company/{company}', 'MutationController@create');

    
///// Version per mutation overview
Route::get('/company/{company}/{mutation}', 'VersionController@show');
    
});
