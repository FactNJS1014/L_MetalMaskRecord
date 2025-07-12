<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\InsertChangeModelController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/search', [GetDataController::class, 'SearchWon']);
Route::get('/get-list-line',[GetDataController::class , 'GetChangeData']);
Route::get('/get-change-model',[GetDataController::class, 'GetModelChange']);
Route::get('/get-pull-data',[GetDataController::class, 'GetPullData']);
Route::get('/get-values',[GetDataController::class, 'GetValues']);
Route::get('/get-values2',[GetDataController::class, 'GetValues2']);


Route::get('/get-list-models',[GetDataController::class, 'GetListModel']);
Route::get('/get-list-mask',[GetDataController::class, 'GetListMask']);
Route::get('/gen-issue-no',[GetDataController::class, 'GetIssueNo']);
Route::get('/get-list-models2',[GetDataController::class, 'GetListModel2']);
// Route::get('/get-edit-data',[GetDataController::class,'GetEditData']);
Route::get('/join-data',[GetDataController::class,'JoinData']);
Route::get('/search-filter',[GetDataController::class,'SearchAllFilters']);
Route::get('/search-Line',[GetDataController::class,'SearchLINE']);
Route::get('/search-Date',[GetDataController::class,'SearchDATE']);
Route::get('/search-qrid',[GetDataController::class,'SearchQRID']);
Route::get('/get-user-name',[GetDataController::class,'GetUserName']);
Route::get('/get-mask-Id',[GetDataController::class,'GetMaskID']);
// Route::get('/insert-change-model', [InsertChangeModelController::class, 'insertChangeModel']);


