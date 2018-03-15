<?php

//////////////////////////// Unrestricted

///// Homepage
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::get('/faq', 'HomeController@faq');

///// Facebook
Route::get('/redirect', 'SocialAuthFacebookController@redirect');

Route::get('/callback', 'SocialAuthFacebookController@callback');

/////Pilslijst
Route::post('/pils', 'PilsController@pils');
Route::get('/pils/', 'PilsController@index');
Route::get('/turf/', 'PilsController@turf');
Route::get('/pils/delete', 'PilsController@delete');


//////////////////////////// Restricted by login

/////Profile overview
Route::get('/profile', 'ProfileController@index');

Route::post('/profile/email', 'ProfileController@email');

Route::post('/profile/iban', 'ProfileController@iban');

Route::post('/profile/password', 'ProfileController@password');

/////Invitations & approvals
Route::get('/invitation/{invitation}', 'InvitationController@accept');

Route::get('/approval/{approval}', 'InvitationController@approval');

///// Dashboard overview
Route::get('/dashboard', 'DashboardController@index');

////////////////////////// Restricted per balance
Route::group(["middleware" => 'checkbalance'], function(){
    
///// Balances
Route::get('/balances/create', 'BalanceController@form');

Route::post('/balances/create', 'BalanceController@create');

Route::post('/balances/editcover/{balance}', 'BalanceController@editcover');
    
Route::get('/balances/{balance}/edit', 'BalanceController@balance');
    
Route::post('/balances/{balance}/edit', 'BalanceController@edit');
    
Route::post('/balances/{balance}/remove', 'BalanceController@remove');
    
Route::post('/balances/{balance}/addusers', 'BalanceController@addusers');

Route::post('/balances/{balance}/admin', 'BalanceController@admin');

Route::post('/balances/users/{balance}/remove/{user}', 'BalanceController@removeuser');
    
Route::post('/balances/users/{balance}/{user}', 'BalanceController@edituser');
    
Route::get('download-pdf/{balance}', 'BalanceController@downloadPDF');

///// Mutations

Route::get('/balances/{balance}', 'BalanceController@index');

Route::post('/balances/{balance}', 'MutationController@create');

Route::post('/balances/{balance}/edit/{mutation}', 'MutationController@edit');
    
Route::get('/balances/{balance}/delete/{mutation}', 'MutationController@delete');

///// Versions

Route::get('/balances/{balance}/history', 'VersionController@history');

Route::get('/balances/{balance}/{mutation}', 'VersionController@index');

});

    

