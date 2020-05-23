<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/users', 'Api\UsersListController');
Route::post('/users', 'Api\UsersCreateController');
Route::put('/users/{id}', 'Api\UsersUpdateController');
Route::delete('/users/{id}', 'Api\UsersDeleteController');

// TASKS
Route::get('/tasks', 'Api\Tasks\TasksListController');
Route::post('/tasks', 'Api\Tasks\TasksCreateController');
Route::put('/tasks/{id}', 'Api\Tasks\TasksUpdateController');
Route::delete('/tasks/{id}', 'Api\Tasks\TasksDeleteController');

// DASHBOARD
Route::get('/dashboard/tasks/status', 'Api\Dashboard\DashboardStatusController');
Route::get('/dashboard/tasks/users', 'Api\Dashboard\DashboardUsersController');



