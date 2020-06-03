<?php

use Illuminate\Http\Request;

//Include auth API
include('api_routes/auth.php');

Route::group(['middleware' => 'auth:api'], function () {
    include('api_routes/user.php');
    include('api_routes/product.php');
    include('api_routes/order.php');
});
