<?php

Route::post('add/item','API\OrderController@addToCart');
Route::post('checkout','API\OrderController@checkout');
