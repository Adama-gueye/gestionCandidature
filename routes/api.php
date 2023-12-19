<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\FormationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [CompteController::class,'register']);
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::middleware(['auth:api', 'role:candidat'])->group(function () {
    Route::post('/createCandidat', [CandidatController::class, 'store']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/formations', [FormationController::class, 'index']);
    Route::post('/createFormation', [FormationController::class, 'store']);
    Route::patch('/updateFormation{id}', [FormationController::class, 'update']);
    Route::delete('/deleteFormation{id}', [FormationController::class, 'destroy']);
    Route::get('/showFormation{id}', [FormationController::class, 'show']);
    Route::get('/candidats', [CandidatController::class, 'index']);
    Route::get('/candidatAccepter', [CandidatController::class, 'candidatAccepter']);
    Route::get('/candidatRefuser', [CandidatController::class, 'candidatRefuser']);
    Route::patch('/updateCandidat{id}', [CandidatController::class, 'update']);
    Route::patch('/updateEtat{id}', [CandidatController::class, 'changeEtat']);

});