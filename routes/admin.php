<?php

use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Employee;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin;

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

Route::post("employees", [EmployeeController::class, "store"]);

Route::prefix("transactions")->group(function () {
    Route::get("/", [TransactionController::class, "index"]);
    Route::post("pay", [TransactionController::class, "pay"]);
});
