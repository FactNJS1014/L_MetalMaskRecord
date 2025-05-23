<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\InsertChangeModelController;
use App\Http\Controllers\UpdateDataController;
use App\Http\Controllers\InsertMetalMaskController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\SessionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/{any}', function () {
    return view('app'); // or whatever your main blade view is
})->where('any', '.*');



Route::post('/get-model-code', [GetDataController::class, 'getModelCode']);
Route::post('/get-show-code', [GetDataController::class, 'getShowCode']);
Route::post('/show-value', [GetDataController::class, 'showValueToInput']);
Route::post('/search', [GetDataController::class, 'SearchWon']);
Route::post('/get-wono', [GetDataController::class, 'getWono']);
Route::post('/insert-change-model', [InsertChangeModelController::class, 'insertChangeModel']);
Route::put('/update-approve',[UpdateDataController::class , 'updateApr']);
Route::post('save-data', [InsertMetalMaskController::class, 'saveData']);
Route::put('/update-notify-status',[UpdateDataController::class, 'updateNotiStatus']);
Route::post('/search-list-models',[GetDataController::class, 'SearchlistModels']);
Route::post('/search-list-masks',[GetDataController::class, 'SearchlistMasks']);
Route::post('/get-change-history',[GetDataController::class, 'GetChangeHistory']);
Route::post('/set-session', [LoginController::class, 'login']);
Route::post('/add-setting-models',[InsertChangeModelController::class, 'addSettingModels']);
Route::post('/add-setting-mask',[InsertMetalMaskController::class, 'addSettingMasks']);
Route::post('/get-edit-data',[GetDataController::class,'GetEditData']);
Route::post('/get-process',[GetDataController::class , 'GetProcess']);
Route::post('/get-edit-model',[GetDataController::class , 'GetEditModel']);
