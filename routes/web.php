<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\InsertChangeModelController;
use App\Http\Controllers\UpdateDataController;
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
    return view('app');
})->where('any', '.*');

Route::post('/get-model-code', [GetDataController::class, 'getModelCode']);
Route::post('/show-value', [GetDataController::class, 'showValueToInput']);
Route::post('/search', [GetDataController::class, 'SearchWon']);
Route::post('/get-wono', [GetDataController::class, 'getWono']);
Route::post('/insert-change-model', [InsertChangeModelController::class, 'insertChangeModel']);
Route::put('/update-approve',[UpdateDataController::class , 'updateApr']);
Route::post('save-data', [InsertChangeModelController::class, 'saveData']);
