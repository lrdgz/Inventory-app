<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], static function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


Route::apiResource('/employee', 'Api\EmployeeController');
Route::apiResource('/supplier', 'Api\SupplierController');
Route::apiResource('/category', 'Api\CategoryController');
Route::apiResource('/product', 'Api\ProductController');
Route::apiResource('/expense', 'Api\ExpenseController');
Route::apiResource('/customer', 'Api\CustomerController');


Route::post('/salary/paid/{employee}', 'Api\SalaryController@paid');
Route::get('/salary/', 'Api\SalaryController@allSalary');
Route::get('/edit/salary/{id}', 'Api\SalaryController@editSalary');
Route::get('/salary/view/{year}/{month}', 'Api\SalaryController@viewSalary');
Route::post('/salary/update/{id}', 'Api\SalaryController@updateSalary');


Route::post('/stock/update/{product}', 'Api\ProductController@stockUpdate');

Route::get('/getting/product/{category}', 'Api\PosController@getProduct');
Route::get('/addToCart/{product}', 'Api\CartController@addToCart');
Route::get('/cart/product', 'Api\CartController@cartProduc');
Route::get('/cart/remove/{id}', 'Api\CartController@removeCart');
Route::get('/cart/increment/{id}', 'Api\CartController@incrementCart');
Route::get('/cart/decrement/{id}', 'Api\CartController@decrementCart');


Route::get('extras', 'Api\CartController@extras');
