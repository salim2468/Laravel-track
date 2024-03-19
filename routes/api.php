<?php

use App\Http\Controllers\Api\ExpenseCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ExpenseController;


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
Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);
Route::middleware('auth:api')->post('/logout', [UserController::class,'logout']);
Route::get('/user/{id}', [UserController::class,'show']);

Route::middleware('auth:api')->group(function () {
Route::apiResource('/expenses', ExpenseController::class);
Route::get('/expenses/{id}/total-expense', [ExpenseController::class,'totalExpense']);
Route::get('/expenses/{id}/monthly', [ExpenseController::class,'latestSixMonthsExpense']);

});

// Route::apiResource('/expenses', ExpenseController::class);


Route::get('/expense-category', [ExpenseCategoryController::class,'index']);
Route::post('/expense-category', [ExpenseCategoryController::class,'store']);
Route::put('/expense-category/{id}', [ExpenseCategoryController::class,'update']);
Route::delete('/expense-category/{id}', [ExpenseCategoryController::class,'destroy']);

