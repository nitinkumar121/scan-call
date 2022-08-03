<?php

use App\Http\Controllers\GenrateTokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VechileDetailController;
use App\Models\vechile_detail;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user/get', [UserController::class, 'get_data']);
Route::post('/user/new', [UserController::class, 'create']);
Route::post('/user/update', [UserController::class, 'update']);
// adding vechile data
Route::post('/vechile/new', [VechileDetailController::class, 'create']);
// send otp and verify email
Route::post('/send_otp' , [UserController::class, 'send_otp']);
Route::post('/generate_token' , [GenrateTokenController::class, 'generateNew']);



