<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Master\RoleController;
use App\Http\Controllers\API\Master\PermissionController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('auth', [AuthController::class, 'auth']);




    Route::get('logout', [AuthController::class, 'logout']);
/*
|--------------------------------------------------------------------------
| API Routes MANAGE START
|--------------------------------------------------------------------------
*/
    Route::resource('user', 'App\Http\Controllers\API\Master\UserController');
    Route::resource('role', 'App\Http\Controllers\API\Master\RoleController');
    Route::resource('permission', 'App\Http\Controllers\API\Master\PermissionController');
    Route::resource('akuntansi', 'App\Http\Controllers\API\Finance\AkuntansiController');
    Route::resource('akuntansi-data', 'App\Http\Controllers\API\Finance\AkuntansiDataController');
    Route::resource('akuntansi-buku-bantu', 'App\Http\Controllers\API\Finance\AkuntansiBukuBantuController');
    Route::resource('akuntansi-jurnal', 'App\Http\Controllers\API\Finance\AkuntansiJurnalController');
    /*
    |--------------------------------------------------------------------------
    | API Routes MANAGE END
    |--------------------------------------------------------------------------
    */
    Route::get('get-roles-item', [RoleController::class, 'getrolesitem']);
    Route::get('get-permission-item', [PermissionController::class, 'getpermissionitem']);

    
    Route::resource('support-notes', 'App\Http\Controllers\API\SupportController');
});

Route::resource('user', 'App\Http\Controllers\API\Master\UserController');
