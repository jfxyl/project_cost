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

$api = app('Dingo\Api\Routing\Router');     //不支持隐式绑定

$api->version('v1', 
    ['namespace' => 'App\Http\Controllers\Api'],
    function($api) {
        $api->post('users', 'UsersController@store');
        $api->post('login', 'AuthorizationsController@login');
        $api->post('modifyPassword','UsersController@modifyPassword');
        $api->post('verificationCode','VerificationCodeController@verificationCode');
        $api->get('items','ItemsController@Items');
        $api->get('projects','ProjectsController@projects');
        $api->get('project','ProjectsController@project');
        $api->get('catalogs','ItemsController@catalogs');

        $api->group(['middleware' => ['jwt.token.refresh']],function($api){
            $api->post('me','UsersController@me');
            $api->post('motifyUserInfo','UsersController@modifyUserInfo');
            $api->post('projects','ProjectsController@store');
            $api->post('project_items','ProjectsController@projectItemsStore');
            $api->get('project_items','ProjectsController@projectItems');
            $api->post('projectUserCatalogs','ProjectsController@projectUserCatalogsStore');
        });
});

