<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', 'TestController@index');
Route::group([
    'prefix'        => 'v1',
    'middleware'    => ['header']
], function () {
    // Token
    Route::group([
        'prefix'    => 'auth',
        'namespace' => 'Api'
    ], function () {
        Route::post('/token', 'AuthenticateController@token');
        Route::post('/token/refresh', 'AuthenticateController@refreshToken')->middleware(['jwt.auth']);
    });

    // App Routes
    Route::group([
        'prefix'        => 'persons',
        'middleware'    => 'jwt.auth'
    ], function () {
        Route::get('{uuid?}', 'PersonController@get')
            ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');

        Route::post('/', 'PersonController@create');

        Route::put('{uuid}', 'PersonController@update')
            ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');

        Route::post('{uuid}/relate', 'PersonController@relate')
            ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');
    });

    Route::group(['prefix' => 'relations'], function () {
        Route::get('{uuid?}', 'RelationController@get')
            ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');

        Route::post('/', 'RelationController@create');

        Route::put('{uuid}', 'RelationController@update')
            ->where('uuid', '[0-9a-fA-F]{8}(-[0-9a-fA-F]{4}){3}-[0-9a-fA-F]{12}');
    });
});
