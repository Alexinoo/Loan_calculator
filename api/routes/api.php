<?php

use App\Http\Controllers\Api\Loan_detailController;
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


// Post Request
Route::get('loan_details/fetch_calculation',[Loan_detailController::class,'index']);


// Post Request
Route::post('loan_details/emi_calculation',[Loan_detailController::class,'CalculateEMI']);

