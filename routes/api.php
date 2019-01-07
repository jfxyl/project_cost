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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', 
    ['namespace' => 'App\Http\Controllers\Api'],
    function($api) {
        $api->post('users', 'UsersController@store')->name('users.store');
        $api->post('login', 'AuthorizationsController@login')->name('authorizations.login');
        $api->post('modifyPassword','UsersController@modifyPassword')->name('users.modifyPassword');
        $api->get('supplyCates','SupplyCatesController@supplyCates')->name('supplyCates.supplyCates');

        $api->group(['middleware' => ['jwt.token.refresh']],function($api){
            $api->post('me','UsersController@me')->name('users.me');
            $api->post('motifyUserInfo','UsersController@modifyUserInfo')->name('users.modifyUserInfo');
        });
});

