<?php

use Illuminate\Http\Request;

Route::group(array('prefix' => 'api'), function () {
    Route::get('getDepartments/{businessLine?}/{position_code?}', array('as' => 'api.getDepartments', 'uses' => 'Api\ApiSaleNetworkController@getDepartments'));
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('api/remove-cache-by-api', array('as' => 'api.removeCacheByApi','uses' => 'Api\ApiRemoveCacheBackendController@index'));