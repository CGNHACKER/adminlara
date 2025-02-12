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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResources([
        'user' => 'API\UserController'
    ]);
    Route::get('profile','API\UserController@profile');
    Route::put('profile','API\UserController@UpdateProfile');
    Route::get('FindUser','API\UserController@FindUser');

    Route::apiResources([
        'roles' => 'API\RolesController'
    ]);

    Route::apiResources([
        'department' => 'API\DepartmentController'
    ]);

    Route::apiResources([
        'holiday' => 'API\HolidayConfigController'
    ]);
    
    Route::apiResources([
        'leave' => 'API\LeaveController'
    ]);
    Route::post('leaveconfirm','API\LeaveController@ConfirmLeave');

    Route::apiResources([
        'leavecategory' => 'API\LeaveCategoryController'
    ]);

    Route::apiResources([
        'dashboard' => 'API\DashboardController'
    ]);

    Route::get('lastactivity','API\DashboardController@lastactivity');
});
