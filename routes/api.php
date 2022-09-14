<?php

use App\Http\Controllers\CallLogController;
use App\Http\Controllers\GenrateTokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VechileDetailController;
use App\Http\Controllers\CarListController;
use App\Models\systemVariabel;
use App\Http\Controllers\SystemVariabelController;
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

Route::post('/get_user', [UserController::class, 'get_data']);
Route::post('/new_user', [UserController::class, 'create']);
Route::post('/user/update', [UserController::class, 'update']);
// adding vechile data
Route::post('/vehicle/new', [VechileDetailController::class, 'create']);
Route::post('/get_vechiles', [VechileDetailController::class, 'get_vehicles']);


// send otp and verify email
Route::post('/send_otp' , [UserController::class, 'send_otp']);
Route::post('/generate_token' , [GenrateTokenController::class, 'generateNew']);
Route::post('/get_car_model_names' , [CarListController::class, 'getList']);
Route::get('/get_brand_names' , [CarListController::class, 'get_brand_names']);
Route::post('/add_device_token' , [GenrateTokenController::class, 'addDeviceToken']);
Route::post('/system_variable' , [SystemVariabelController::class, 'index']);
Route::post('/logout' , [UserController::class, 'logout']);
Route::post('/updateEmail' , [UserController::class, 'updateEmail']);
Route::post('/get_call_details' , [CallLogController::class , 'get_call_details']);
Route::post('/update_call_details' , [CallLogController::class , 'update_call_details']);
Route::post('/add_call_details' , [CallLogController::class , 'add_call_details']);

















