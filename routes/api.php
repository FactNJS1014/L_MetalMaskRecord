<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;

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
Route::get('/search-mask',[GetDataController::class,'SearchMask']);
Route::get('/user/session', function () {
    return response()->json([
        'username' => session('username'),
        'empno' => session('empno'),
        'department' => session('department'),
        'USER_PERMISSION' => session('USER_PERMISSION'),
        'sec' => session('sec'),
        'MSECT_ID' => session('MSECT_ID'),
    ]);
});
Route::get('/session-data', function () {
    return response()->json([
        'username' => session('username'),
        'empno' => session('empno'),
        'department' => session('department'),
        'USE_PERMISSION' => session('USE_PERMISSION'),
        'sec' => session('sec'),
        'MSECT_ID' => session('MSECT_ID'),
    ]);
});

