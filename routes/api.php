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


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('/expenses', ExpenseController::class);
Route::get('/users/{id}/expenses', [ExpenseController::class,'allExpenses']);


Route::get('/catagory', [ExpenseCategoryController::class,'index']);
Route::post('/catagory', [ExpenseCategoryController::class,'store']);
Route::put('/catagory/{id}', [ExpenseCategoryController::class,'update']);
Route::delete('/catagory', [ExpenseCategoryController::class,'delete']);

