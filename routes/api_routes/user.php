<?php

Route::post('topup/me','API\UserController@topup');
Route::post('profile','API\UserController@profile');
Route::get('profile/topup-history','API\UserController@topUpHistory');
Route::get('cart','API\UserController@getCart');
